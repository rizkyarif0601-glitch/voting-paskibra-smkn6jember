<?php

namespace Database\Factories;

use App\Models\Voter;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Voter>
 */
class VoterFactory extends Factory
{
    protected $model = Voter::class;

    /**
     * Definisi state default factory.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'token' => strtoupper(Str::random(6)),
            'is_voted' => false,
            'voted_at' => null,
        ];
    }

    /**
     * State: pemilih yang sudah memberikan suara.
     */
    public function hasVoted(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_voted' => true,
            'voted_at' => now(),
        ]);
    }

    /**
     * State: pemilih yang belum memberikan suara.
     */
    public function hasNotVoted(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_voted' => false,
            'voted_at' => null,
        ]);
    }
}
