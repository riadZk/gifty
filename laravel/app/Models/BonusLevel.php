<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BonusLevel extends Model
{
    protected $fillable = [
        'name',
        'required_points',
        'reward_name',
        'reward_description',
        'image',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'required_points' => 'decimal:2',
        'is_active'       => 'boolean',
        'sort_order'      => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('required_points');
    }
}
