<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class BonusRequest extends Model
{
    const STATUS_PENDING   = 'pending';
    const STATUS_APPROVED  = 'approved';
    const STATUS_REJECTED  = 'rejected';
    const STATUS_DELIVERED = 'delivered';

    protected $fillable = [
        'demande_key',
        'client_id',
        'bonus_level_id',
        'points_required',
        'status',
        'approved_by',
        'requested_at',
        'approved_at',
        'rejected_at',
        'notes',
    ];

    // ── Auto-generate unique demande_key ──────────────────────────────────────

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (self $model): void {
            if (empty($model->demande_key)) {
                do {
                    $key = 'DB-' . strtoupper(Str::random(8));
                } while (static::where('demande_key', $key)->exists());

                $model->demande_key = $key;
            }
        });
    }

    protected $casts = [
        'points_required' => 'decimal:2',
        'requested_at'    => 'datetime',
        'approved_at'     => 'datetime',
        'rejected_at'     => 'datetime',
    ];

    // ── Relationships ─────────────────────────────────────────────────────────

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function bonusLevel(): BelongsTo
    {
        return $this->belongsTo(BonusLevel::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function transaction(): HasOne
    {
        return $this->hasOne(BonusTransaction::class);
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isApproved(): bool
    {
        return $this->status === self::STATUS_APPROVED;
    }

    public function isRejected(): bool
    {
        return $this->status === self::STATUS_REJECTED;
    }

    public function isDelivered(): bool
    {
        return $this->status === self::STATUS_DELIVERED;
    }
}
