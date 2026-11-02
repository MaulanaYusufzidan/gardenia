<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpkResult extends Model
{
    protected $fillable = [
        'user_id', 'budget_input', 'area_input',
        'style_preference', 'duration_pref',
        'ranking_result', 'recommended_package_id'
    ];

    protected $casts = [
        'ranking_result' => 'array',
        'budget_input'   => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function recommendedPackage()
    {
        return $this->belongsTo(DesignPackage::class, 'recommended_package_id');
    }
}
