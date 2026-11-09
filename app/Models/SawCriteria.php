<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class SawCriteria extends Model
{
    protected $table    = 'saw_criteria';
    protected $fillable = [
        'code', 'name', 'type', 'unit', 'data_source', 'measurement', 'rationale',
        'weight', 'description', 'is_active',
    ];
    protected $casts    = [
        'weight'    => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /** Label tipe dalam bahasa Indonesia untuk tampilan. */
    public function typeLabel(): string
    {
        return $this->type === 'cost' ? 'Cost (semakin kecil semakin baik)' : 'Benefit (semakin besar semakin baik)';
    }
}
