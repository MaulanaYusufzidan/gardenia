<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DesignPackage extends Model
{
    protected $fillable = [
        'name', 'category', 'budget_min', 'budget_max',
        'area_min', 'area_max', 'duration_months',
        'feature_score', 'material_score',
        'description', 'includes', 'image', 'price_start', 'is_active'
    ];

    protected $casts = [
        'budget_min'     => 'decimal:2',
        'budget_max'     => 'decimal:2',
        'price_start'    => 'decimal:2',
        'feature_score'  => 'decimal:2',
        'material_score' => 'decimal:2',
        'is_active'      => 'boolean',
    ];
}
