<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SpkResult extends Model
{
    protected $fillable = [
        'token', 'user_id', 'budget_input', 'area_input',
        'style_preference', 'duration_pref',
        'ranking_result', 'calculation', 'recommended_package_id',
    ];

    protected $casts = [
        'ranking_result' => 'array',
        'calculation'    => 'array',
        'budget_input'   => 'decimal:2',
        'area_input'     => 'integer',
        'duration_pref'  => 'integer',
    ];

    protected static function booted(): void
    {
        // Token acak sebagai alamat publik hasil perhitungan (tidak dapat ditebak,
        // sehingga hasil tamu pun bisa dibuka ulang tanpa membocorkan data orang lain).
        static::creating(function (self $result) {
            $result->token ??= (string) Str::uuid();
        });
    }

    public function getRouteKeyName(): string
    {
        return 'token';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function recommendedPackage()
    {
        return $this->belongsTo(DesignPackage::class, 'recommended_package_id');
    }
}
