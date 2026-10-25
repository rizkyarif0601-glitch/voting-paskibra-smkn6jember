<?php

namespace Tests\Feature;

use App\Models\Candidate;
use App\Models\Voter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VotingSecurityTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Memastikan pemilih tanpa token ditolak saat menembak langsung ke /voting/ballot.
     */
    public function test_cannot_access_ballot_without_token_session(): void
    {
        $response = $this->get('/voting/ballot');

        $response->assertRedirect('/voting');
        $response->assertSessionHasErrors('token');
    }

    /**
     * Memastikan pemilih ditolak jika token di session sudah terpakai (is_voted = true).
     */
    public function test_cannot_access_ballot_with_already_voted_token(): void
    {
        $voter = Voter::factory()->create([
            'token' => 'ABC123',
            'is_voted' => true,
        ]);

        $response = $this->withSession(['voting_token' => 'ABC123'])
            ->get('/voting/ballot');

        $response->assertRedirect('/voting');
        $response->assertSessionHasErrors('token');
    }

    /**
     * Memastikan pemilih ditolak jika token di session tidak ada di database.
     */
    public function test_cannot_access_ballot_with_non_existent_token(): void
    {
        $response = $this->withSession(['voting_token' => 'FAKE99'])
            ->get('/voting/ballot');

        $response->assertRedirect('/voting');
        $response->assertSessionHasErrors('token');
    }

    /**
     * Memastikan membuka halaman input token /voting membersihkan sisa session lama.
     */
    public function test_visiting_voting_index_clears_old_session_token(): void
    {
        $response = $this->withSession(['voting_token' => 'OLDTOK'])
            ->get('/voting');

        $response->assertStatus(200);
        $response->assertSessionMissing('voting_token');
    }

    /**
     * Memastikan pemilih dengan token valid dan belum memilih BISA mengakses ballot.
     */
    public function test_valid_voter_can_access_ballot(): void
    {
        $voter = Voter::factory()->create([
            'token' => 'VALID1',
            'is_voted' => false,
        ]);

        $candidate = Candidate::factory()->create([
            'paslon_number' => 1,
            'leader_name' => 'Kandidat Uji',
        ]);

        $response = $this->withSession(['voting_token' => 'VALID1'])
            ->get('/voting/ballot');

        $response->assertStatus(200);
        $response->assertSee('Kandidat Uji');
    }

    /**
     * Memastikan autentikasi token menoleransi kekeliruan karakter ambigu (angka 0 vs huruf O, angka 1 vs huruf I).
     */
    public function test_voter_authentication_supports_typo_tolerance_for_ambiguous_characters(): void
    {
        Voter::factory()->create([
            'token' => '2A0B1C',
            'is_voted' => false,
        ]);

        // Pemilih mengetik O (huruf O) padahal di token adalah 0 (angka nol)
        $response = $this->post('/voting/authenticate', [
            'token' => '2AOB1C',
        ]);

        $response->assertRedirect('/voting/ballot');
        $response->assertSessionHas('voting_token', '2A0B1C');
    }

    /**
     * Memastikan pengiriman suara berhasil tercatat rahasia dan status pemilih diperbarui.
     */
    public function test_voting_submission_records_vote_and_marks_voter_as_voted(): void
    {
        $voter = Voter::factory()->create([
            'token' => 'TK9999',
            'is_voted' => false,
        ]);

        $candidate = Candidate::factory()->create([
            'paslon_number' => 1,
            'leader_name' => 'Kandidat Sukses',
        ]);

        $response = $this->withSession(['voting_token' => 'TK9999'])
            ->post('/voting/submit', [
                'candidate_id' => $candidate->id,
            ]);

        $response->assertRedirect('/voting/thank-you');
        $this->assertDatabaseHas('votes', ['candidate_id' => $candidate->id]);
        $this->assertTrue($voter->fresh()->is_voted);
    }

    /**
     * Memastikan submit dengan token yang sudah terpakai ditolak dengan aman ke /voting tanpa error 404/500.
     */
    public function test_duplicate_vote_submission_gracefully_redirects_to_index_with_error(): void
    {
        $voter = Voter::factory()->create([
            'token' => 'DBL999',
            'is_voted' => true,
        ]);

        $candidate = Candidate::factory()->create([
            'paslon_number' => 1,
        ]);

        $response = $this->withSession(['voting_token' => 'DBL999'])
            ->post('/voting/submit', [
                'candidate_id' => $candidate->id,
            ]);

        $response->assertRedirect('/voting');
        $response->assertSessionHasErrors('token');
    }
}
