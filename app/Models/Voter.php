<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voter extends Model
{
    use HasFactory;

    /**
     * Kolom yang dapat diisi secara massal (mass assignment).
     *
     * @var list<string>
     */
    protected $fillable = [
        'token',
        'is_voted',
        'voted_at',
    ];

    /**
     * Cast tipe data kolom.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_voted' => 'boolean',
        'voted_at' => 'datetime',
    ];

    /**
     * Tandai pemilih sebagai sudah memberikan suara.
     * Dipanggil setelah proses voting berhasil disimpan.
     */
    public function markAsVoted(): void
    {
        $this->update([
            'is_voted' => true,
            'voted_at' => now(),
        ]);
    }

    /**
     * Scope: hanya pemilih yang belum memberikan suara.
     */
    public function scopeHasNotVoted(Builder $query): Builder
    {
        return $query->where('is_voted', false);
    }

    /**
     * Scope: hanya pemilih yang sudah memberikan suara.
     */
    public function scopeHasVoted(Builder $query): Builder
    {
        return $query->where('is_voted', true);
    }
}
