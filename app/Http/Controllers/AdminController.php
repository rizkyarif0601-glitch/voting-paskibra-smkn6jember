<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Vote;
use App\Models\Voter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Dashboard utama admin — statistik + quick count.
     */
    public function dashboard(): View
    {
        // ── Statistik Pemilih ─────────────────────────────
        $totalVoters = Voter::count();
        $totalVoted = Voter::hasVoted()->count();
        $totalNotVoted = Voter::hasNotVoted()->count();
        $participationRate = $totalVoters > 0
            ? round(($totalVoted / $totalVoters) * 100, 1)
            : 0;

        // ── Data Suara per Paslon (Quick Count) ───────────
        /** @var Collection<int, Candidate> $candidates */
        $candidates = Candidate::withCount('votes')
            ->orderBy('paslon_number')
            ->get();

        $totalVotes = Vote::count();

        // Format untuk Chart.js
        $chartLabels = $candidates->map(
            fn (Candidate $c) => "Kandidat {$c->paslon_number}"
        )->toArray();

        $chartData = $candidates->pluck('votes_count')->toArray();

        $chartColors = [
            'rgba(16, 185, 129, 0.85)',  // emerald
            'rgba(59, 130, 246, 0.85)',  // blue
            'rgba(245, 158, 11, 0.85)',  // amber
            'rgba(239, 68, 68, 0.85)',   // red
            'rgba(168, 85, 247, 0.85)',  // purple
        ];

        // Nama kandidat untuk tooltip Chart.js
        $chartCandidateNames = $candidates
            ->map(fn (Candidate $c) => $c->leader_name)
            ->toArray();

        // ── Daftar Token ──────────────────────────────────
        $voters = Voter::orderByDesc('created_at')->paginate(20);

        return view('admin.dashboard', compact(
            'totalVoters',
            'totalVoted',
            'totalNotVoted',
            'participationRate',
            'candidates',
            'totalVotes',
            'chartLabels',
            'chartData',
            'chartColors',
            'chartCandidateNames',
            'voters',
        ));
    }

    /**
     * Generate sejumlah token acak unik dan simpan ke database.
     */
    public function generateTokens(Request $request): RedirectResponse
    {
        $request->validate([
            'amount' => ['required', 'integer', 'min:1', 'max:500'],
        ], [
            'amount.required' => 'Jumlah token wajib diisi.',
            'amount.integer' => 'Jumlah token harus berupa angka bulat.',
            'amount.min' => 'Minimal generate 1 token.',
            'amount.max' => 'Maksimal generate 500 token sekaligus.',
        ]);

        $amount = (int) $request->input('amount');
        $generated = 0;
        $maxTries = $amount * 5; // batas percobaan agar tidak infinite loop
        $tries = 0;

        $charset = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ';
        $charsetLen = strlen($charset);

        while ($generated < $amount && $tries < $maxTries) {
            $tries++;
            // Token: 6 karakter alfanumerik uppercase tanpa karakter ambigu (0, O, 1, I)
            $token = '';
            for ($i = 0; $i < 6; $i++) {
                $token .= $charset[random_int(0, $charsetLen - 1)];
            }

            // Pastikan unik — skip jika sudah ada
            if (Voter::where('token', $token)->exists()) {
                continue;
            }

            Voter::create(['token' => $token]);
            $generated++;
        }

        return redirect()->route('admin.dashboard')
            ->with('success', "Berhasil membuat {$generated} token baru.");
    }

    /**
     * Halaman cetak token — layout A4 siap print.
     */
    public function printTokens(): View
    {
        // Ambil semua token yang belum digunakan untuk dicetak
        $voters = Voter::hasNotVoted()
            ->orderBy('created_at')
            ->get();

        return view('admin.print-tokens', compact('voters'));
    }

    /**
     * Hapus satu token (hanya yang belum digunakan).
     */
    public function deleteToken(Voter $voter): RedirectResponse
    {
        if ($voter->is_voted) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Token yang sudah digunakan tidak dapat dihapus.');
        }

        $voter->delete();

        return redirect()->route('admin.dashboard')
            ->with('success', "Token {$voter->token} berhasil dihapus.");
    }

    /**
     * Hapus semua token yang belum digunakan.
     */
    public function deleteUnusedTokens(): RedirectResponse
    {
        $count = Voter::hasNotVoted()->count();
        Voter::hasNotVoted()->delete();

        return redirect()->route('admin.dashboard')
            ->with('success', "Berhasil menghapus {$count} token yang belum digunakan.");
    }

    /**
     * Reset semua hasil pemilihan — hapus semua suara & kembalikan
     * status voters ke belum memilih. Digunakan untuk simulasi / uji coba.
     */
    public function clearResults(): RedirectResponse
    {
        // Hapus semua records di tabel votes
        Vote::truncate();

        // Reset semua voter ke status belum memilih
        Voter::query()->update([
            'is_voted' => false,
            'voted_at' => null,
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Semua hasil pemilihan berhasil direset. Sistem siap untuk simulasi baru.');
    }

    /**
     * Update data kandidat (Nama, Visi, Misi, Foto).
     */
    public function updateCandidate(Request $request, Candidate $candidate): RedirectResponse
    {
        $validated = $request->validate([
            'leader_name' => ['required', 'string', 'max:255'],
            'vision' => ['required', 'string'],
            'mission' => ['required', 'string'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:3072'],
        ], [
            'leader_name.required' => 'Nama kandidat wajib diisi.',
            'vision.required' => 'Visi wajib diisi.',
            'mission.required' => 'Misi wajib diisi.',
            'photo.image' => 'File foto harus berupa gambar.',
            'photo.mimes' => 'Format foto harus jpeg, png, jpg, atau webp.',
            'photo.max' => 'Ukuran foto maksimal 3MB.',
        ]);

        if ($request->hasFile('photo')) {
            // Hapus file foto lama di storage jika ada
            if ($candidate->photo && Storage::disk('public')->exists($candidate->photo)) {
                Storage::disk('public')->delete($candidate->photo);
            }

            $path = $request->file('photo')->store('candidates', 'public');
            $candidate->photo = $path;
        }

        $candidate->leader_name = $validated['leader_name'];
        $candidate->vision = $validated['vision'];
        $candidate->mission = $validated['mission'];
        $candidate->save();

        return redirect()->route('admin.dashboard')
            ->with('success', "Data Kandidat {$candidate->paslon_number} ({$candidate->leader_name}) berhasil diperbarui.");
    }

    /**
     * Halaman live perolehan suara (Quick Count) mandiri untuk layar monitor / proyektor.
     */
    public function realtime(): View
    {
        $totalVoters = Voter::count();
        $totalVoted = Voter::hasVoted()->count();
        $totalNotVoted = Voter::hasNotVoted()->count();
        $totalVotes = Vote::count();
        $participationRate = $totalVoters > 0
            ? round(($totalVoted / $totalVoters) * 100, 1)
            : 0;

        /** @var Collection<int, Candidate> $candidates */
        $candidates = Candidate::withCount('votes')
            ->orderBy('paslon_number')
            ->get();

        return view('admin.realtime', compact(
            'candidates',
            'totalVoters',
            'totalVoted',
            'totalNotVoted',
            'totalVotes',
            'participationRate'
        ));
    }

    /**
     * API JSON perolehan suara real-time untuk polling AJAX.
     */
    public function realtimeData(): JsonResponse
    {
        $totalVoters = Voter::count();
        $totalVoted = Voter::hasVoted()->count();
        $totalNotVoted = Voter::hasNotVoted()->count();
        $totalVotes = Vote::count();
        $participationRate = $totalVoters > 0
            ? round(($totalVoted / $totalVoters) * 100, 1)
            : 0;

        $candidates = Candidate::withCount('votes')
            ->orderBy('paslon_number')
            ->get()
            ->map(function (Candidate $c) use ($totalVotes) {
                $percentage = $totalVotes > 0
                    ? round(($c->votes_count / $totalVotes) * 100, 1)
                    : 0;

                return [
                    'id' => $c->id,
                    'paslon_number' => $c->paslon_number,
                    'leader_name' => $c->leader_name,
                    'photo_url' => $c->photo_url,
                    'votes_count' => $c->votes_count,
                    'percentage' => $percentage,
                ];
            });

        return response()->json([
            'total_voters' => $totalVoters,
            'total_voted' => $totalVoted,
            'total_not_voted' => $totalNotVoted,
            'total_votes' => $totalVotes,
            'participation_rate' => $participationRate,
            'candidates' => $candidates,
            'updated_at' => now()->format('H:i:s'),
        ]);
    }
}
