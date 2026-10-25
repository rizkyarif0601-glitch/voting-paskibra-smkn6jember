<?php

namespace App\Http\Middleware;

use App\Models\Voter;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureValidVotingToken
{
    /**
     * Handle an incoming request.
     *
     * Memastikan hanya pemilih dengan token valid di session
     * DAN belum pernah memilih di database yang boleh membuka surat suara atau mengirim suara.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->session()->get('voting_token');

        if (! $token) {
            return redirect()->route('voting.index')
                ->withErrors(['token' => 'Akses ditolak. Silakan masukkan token Anda terlebih dahulu untuk membuka surat suara.']);
        }

        // Validasi keaslian token dan status memilih di database
        $voter = Voter::where('token', $token)->first();

        if (! $voter) {
            $request->session()->forget('voting_token');

            return redirect()->route('voting.index')
                ->withErrors(['token' => 'Token tidak ditemukan atau tidak valid. Silakan masukkan token yang benar.']);
        }

        if ($voter->is_voted) {
            $request->session()->forget('voting_token');

            return redirect()->route('voting.index')
                ->withErrors(['token' => 'Token ini sudah digunakan untuk memilih. Setiap token hanya berlaku satu kali.']);
        }

        $response = $next($request);

        // Mencegah cache browser (agar tombol Back / riwayat tab tidak bisa membuka surat suara yang sudah selesai)
        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');

        return $response;
    }
}
