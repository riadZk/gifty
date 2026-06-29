<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoyaltySetting extends Model
{
    protected $fillable = [
        'currency',
        'amount_value',
        'points_value',
        'annual_reset',
    ];

    protected $casts = [
        'amount_value'  => 'decimal:2',
        'points_value'  => 'decimal:2',
        'annual_reset'  => 'boolean',
    ];

    /**
     * Return the single settings row, creating it with defaults if absent.
     */
    public static function instance(): static
    {
        return static::firstOrCreate([], [
            'currency'     => 'MAD',
            'amount_value' => 1.00,
            'points_value' => 1.00,
            'annual_reset' => false,
        ]);
    }
}
