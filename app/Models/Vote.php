<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vote extends Model
{
    use HasFactory;

    /**
     * Tabel ini hanya memiliki created_at (tanpa updated_at)
     * karena suara yang sudah diberikan tidak boleh diubah.
     */
    public const UPDATED_AT = null;

    /**
     * Kolom yang dapat diisi secara massal (mass assignment).
     *
     * Catatan: voter_id SENGAJA tidak ada di sini demi menjaga
     * kerahasiaan suara sesuai asas LUBER JURDIL (asas RAHASIA).
     *
     * @var list<string>
     */
    protected $fillable = [
        'candidate_id',
    ];

    /**
     * Cast tipe data kolom.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'candidate_id' => 'integer',
        'created_at' => 'datetime',
    ];

    /**
     * Relasi: setiap suara diberikan kepada satu paslon.
     */
    public function candidate(): BelongsTo
    {
        return $this->belongsTo(Candidate::class);
    }
}
