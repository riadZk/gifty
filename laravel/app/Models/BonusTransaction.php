<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BonusTransaction extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'client_id',
        'bonus_request_id',
        'bonus_level_id',
        'points_before',
        'points_used',
        'points_after',
    ];

    protected $casts = [
        'points_before' => 'decimal:2',
        'points_used'   => 'decimal:2',
        'points_after'  => 'decimal:2',
        'created_at'    => 'datetime',
    ];

    // ── Relationships ─────────────────────────────────────────────────────────

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function bonusRequest(): BelongsTo
    {
        return $this->belongsTo(BonusRequest::class);
    }

    public function bonusLevel(): BelongsTo
    {
        return $this->belongsTo(BonusLevel::class);
    }
}
