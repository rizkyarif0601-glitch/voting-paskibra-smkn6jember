<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Vote;
use App\Models\Voter;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class VotingController extends Controller
{
    /**
     * Halaman utama — form input token pemilih.
     */
    public function index(Request $request): View
    {
        // Selalu bersihkan session token jika pemilih kembali ke halaman awal
        $request->session()->forget('voting_token');

        $candidates = collect();
        try {
            $candidates = Candidate::orderBy('paslon_number')->get();
        } catch (\Throwable) {
            // Abaikan jika tabel candidates belum tersedia
        }

        return view('voting.index', compact('candidates'));
    }

    /**
     * Autentikasi token yang dimasukkan pemilih.
     *
     * Alur:
     * 1. Validasi format token (6 karakter alfanumerik).
     * 2. Proteksi brute-force dengan RateLimiter per IP.
     * 3. Cari token di database (dengan toleransi typo angka 0/huruf O dan angka 1/huruf I).
     * 4. Jika token tidak ditemukan → error "Token tidak valid".
     * 5. Jika token sudah terpakai (is_voted = true) → error "Sudah memilih".
     * 6. Jika valid → simpan token ke session & redirect ke surat suara.
     */
    public function authenticateToken(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required', 'string', 'size:6', 'alpha_num'],
        ], [
            'token.required' => 'Token wajib diisi.',
            'token.size' => 'Token harus terdiri dari tepat 6 karakter.',
            'token.alpha_num' => 'Token hanya boleh berisi huruf dan angka.',
        ]);

        $throttleKey = 'token-auth|'.$request->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 10)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            return back()->withErrors([
                'token' => "Terlalu banyak percobaan token yang salah. Silakan coba lagi dalam {$seconds} detik.",
            ])->withInput();
        }

        $inputToken = strtoupper($request->input('token'));

        // 1. Coba pencocokan langsung
        $voter = Voter::where('token', $inputToken)->first();

        // 2. Toleransi typo manusia: jika tidak ditemukan, periksa variasi ambigu angka 0 / huruf O, angka 1 / huruf I
        if (! $voter) {
            $ambiguousReplacements = [
                ['O', '0'],
                ['0', 'O'],
                ['I', '1'],
                ['1', 'I'],
            ];

            foreach ($ambiguousReplacements as [$search, $replace]) {
                if (str_contains($inputToken, $search)) {
                    $altToken = str_replace($search, $replace, $inputToken);
                    $potentialVoters = Voter::where('token', $altToken)->get();
                    if ($potentialVoters->count() === 1) {
                        $voter = $potentialVoters->first();
                        $inputToken = $voter->token;
                        break;
                    }
                }
            }
        }

        if (! $voter) {
            RateLimiter::hit($throttleKey, 60);

            return back()->withErrors([
                'token' => 'Token tidak valid. Periksa kembali token Anda.',
            ])->withInput();
        }

        if ($voter->is_voted) {
            return back()->withErrors([
                'token' => 'Token ini sudah digunakan. Setiap pemilih hanya dapat memilih satu kali.',
            ])->withInput();
        }

        RateLimiter::clear($throttleKey);

        // Simpan token ke session sebagai tanda bahwa pemilih telah terautentikasi
        $request->session()->put('voting_token', $voter->token);

        return redirect()->route('voting.ballot');
    }

    /**
     * Halaman surat suara — menampilkan semua kandidat.
     *
     * Hanya dapat diakses jika session 'voting_token' ada, valid di database,
     * dan belum pernah digunakan untuk memilih.
     */
    public function showBallot(Request $request): Response
    {
        $votingToken = $request->session()->get('voting_token');

        if (! $votingToken) {
            return redirect()->route('voting.index')
                ->withErrors(['token' => 'Akses ditolak. Silakan masukkan token Anda terlebih dahulu untuk membuka surat suara.']);
        }

        $voter = Voter::where('token', $votingToken)->first();

        if (! $voter || $voter->is_voted) {
            $request->session()->forget('voting_token');

            return redirect()->route('voting.index')
                ->withErrors(['token' => 'Token tidak valid atau sudah digunakan. Silakan masukkan token baru.']);
        }

        $candidates = Candidate::orderBy('paslon_number')->get();

        return response()
            ->view('voting.ballot', compact('candidates'))
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
    }

    /**
     * Proses pengiriman suara dari surat suara.
     *
     * Alur transaksi database:
     * a. Insert record baru ke tabel votes (hanya candidate_id, tanpa voter_id).
     * b. Update status voter: is_voted = true, voted_at = now().
     *
     * Session token dihapus setelah berhasil agar tidak bisa digunakan ulang.
     */
    public function submitVote(Request $request): RedirectResponse
    {
        $votingToken = $request->session()->get('voting_token');

        // Validasi: pemilih harus memiliki session token yang valid
        if (! $votingToken) {
            return redirect()->route('voting.index')
                ->withErrors(['token' => 'Sesi telah berakhir. Silakan masukkan token Anda kembali.']);
        }

        $request->validate([
            'candidate_id' => ['required', 'integer', 'exists:candidates,id'],
        ], [
            'candidate_id.required' => 'Silakan pilih salah satu kandidat.',
            'candidate_id.exists' => 'Kandidat yang dipilih tidak valid.',
        ]);

        $candidateId = (int) $request->input('candidate_id');

        try {
            DB::transaction(function () use ($votingToken, $candidateId): void {
                // Kunci baris voter agar tidak ada race condition (double voting)
                $voter = Voter::where('token', $votingToken)
                    ->where('is_voted', false)
                    ->lockForUpdate()
                    ->firstOrFail();

                // a. Simpan suara — voter_id TIDAK disimpan demi asas RAHASIA
                Vote::create(['candidate_id' => $candidateId]);

                // b. Tandai pemilih sebagai sudah memilih
                $voter->markAsVoted();
            });
        } catch (ModelNotFoundException) {
            $request->session()->forget('voting_token');

            // Jika token sudah tercatat pernah memilih (misal pemilih double-click cepat di layar sentuh), arahkan dengan aman ke thank-you
            if (Voter::where('token', $votingToken)->where('is_voted', true)->exists()) {
                $request->session()->flash('vote_completed', true);

                return redirect()->route('voting.thank-you');
            }

            return redirect()->route('voting.index')
                ->withErrors(['token' => 'Token tidak valid atau sudah digunakan.']);
        }

        // Hapus session token agar tidak bisa digunakan lagi
        $request->session()->forget('voting_token');
        $request->session()->flash('vote_completed', true);

        return redirect()->route('voting.thank-you');
    }

    /**
     * Halaman ucapan terima kasih setelah berhasil memilih.
     */
    public function thankYou(Request $request): View|RedirectResponse
    {
        if (! $request->session()->has('vote_completed')) {
            return redirect()->route('voting.index');
        }

        return view('voting.thank-you');
    }
}
