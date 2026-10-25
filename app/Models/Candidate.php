<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Candidate extends Model
{
    use HasFactory;

    /**
     * Kolom yang dapat diisi secara massal (mass assignment).
     *
     * @var list<string>
     */
    protected $fillable = [
        'paslon_number',
        'leader_name',
        'photo',
        'vision',
        'mission',
    ];

    /**
     * Cast tipe data kolom.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'paslon_number' => 'integer',
    ];

    /**
     * Relasi: satu paslon memiliki banyak suara.
     */
    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    /**
     * Hitung total suara yang diperoleh paslon ini.
     */
    public function getTotalVotesAttribute(): int
    {
        return $this->votes()->count();
    }

    /**
     * Resolusi URL foto kandidat dengan dukungan upload storage
     * maupun auto-detect dari folder public/images/candidates/.
     */
    public function getPhotoUrlAttribute(): ?string
    {
        if ($this->photo) {
            if (str_starts_with($this->photo, 'http://') || str_starts_with($this->photo, 'https://')) {
                return $this->photo;
            }

            if (file_exists(public_path($this->photo))) {
                return asset($this->photo);
            }

            if (file_exists(storage_path('app/public/'.$this->photo))) {
                return asset('storage/'.$this->photo);
            }
        }

        $matches = glob(public_path("images/candidates/kandidat-{$this->paslon_number}.*"));
        if (! empty($matches)) {
            foreach ($matches as $match) {
                $ext = strtolower(pathinfo($match, PATHINFO_EXTENSION));
                if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
                    return asset('images/candidates/'.basename($match));
                }
            }
        }

        return null;
    }
}
