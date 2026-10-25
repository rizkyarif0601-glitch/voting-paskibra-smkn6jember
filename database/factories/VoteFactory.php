<?php

namespace Database\Factories;

use App\Models\Candidate;
use App\Models\Vote;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Vote>
 */
class VoteFactory extends Factory
{
    protected $model = Vote::class;

    /**
     * Definisi state default factory.
     *
     * Catatan: voter_id SENGAJA tidak ada demi menjaga
     * kerahasiaan suara (asas RAHASIA pada LUBER JURDIL).
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'candidate_id' => Candidate::factory(),
        ];
    }

    /**
     * State: suara untuk paslon tertentu.
     */
    public function forCandidate(Candidate $candidate): static
    {
        return $this->state(fn (array $attributes) => [
            'candidate_id' => $candidate->id,
        ]);
    }
}
