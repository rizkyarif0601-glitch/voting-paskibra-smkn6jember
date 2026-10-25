<?php

namespace Database\Factories;

use App\Models\Candidate;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Candidate>
 */
class CandidateFactory extends Factory
{
    protected $model = Candidate::class;

    /**
     * Nomor paslon yang digunakan secara berurutan agar unik.
     */
    private static int $paslon_number = 1;

    /**
     * Definisi state default factory.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'paslon_number' => self::$paslon_number++,
            'leader_name' => fake()->name('male'),
            'photo' => null,
            'vision' => fake()->paragraph(2),
            'mission' => implode("\n", fake()->sentences(5)),
        ];
    }

    /**
     * State: reset penomoran paslon (berguna saat testing).
     */
    public function withPaslonNumber(int $number): static
    {
        return $this->state(fn (array $attributes) => [
            'paslon_number' => $number,
        ]);
    }

    /**
     * State: paslon dengan foto.
     */
    public function withPhoto(): static
    {
        return $this->state(fn (array $attributes) => [
            'photo' => 'candidates/'.fake()->uuid().'.jpg',
        ]);
    }
}
