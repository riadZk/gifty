<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Client extends Authenticatable implements HasMedia
{
    use HasApiTokens, Notifiable, InteractsWithMedia;

    // ── Status constants ──────────────────────────────────────────────────────
    const STATUS_ACTIVE   = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_BLOCKED  = 'blocked';

    protected $fillable = [
        'company_name',
        'contact_name',
        'email',
        'phone',
        'pcc_customer_code',
        'password',
        'status',
        'points_balance',
        'total_sales',
        'accepted_at',
        'accepted_by',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'points_balance' => 'decimal:2',
        'total_sales'    => 'decimal:2',
        'password'       => 'hashed',
        'accepted_at'    => 'datetime',
    ];

    // ── Points formula ────────────────────────────────────────────────────────

    /**
     * Calculate points earned from an HT sale amount.
     * Formula: points = amount_ht * 0.02
     */
    public static function calculatePoints(float $amountHt): float
    {
        return round($amountHt * 0.02, 2);
    }

    public function addPoints(float $amountHt): void
    {
        $this->increment('points_balance', self::calculatePoints($amountHt));
    }

    // ── Scopes ────────────────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', self::STATUS_INACTIVE);
    }

    public function scopeBlocked($query)
    {
        return $query->where('status', self::STATUS_BLOCKED);
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function isInactive(): bool
    {
        return $this->status === self::STATUS_INACTIVE;
    }

    public function isBlocked(): bool
    {
        return $this->status === self::STATUS_BLOCKED;
    }

    public function acceptedBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'accepted_by');
    }

    public function activate(int $byUserId = null): void
    {
        $this->update([
            'status'      => self::STATUS_ACTIVE,
            'accepted_at' => now(),
            'accepted_by' => $byUserId,
        ]);
    }

    public function block(): void
    {
        $this->update(['status' => self::STATUS_BLOCKED]);
    }

    // ── Media ─────────────────────────────────────────────────────────────────

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('picture')->singleFile();
    }

    public function getPictureUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('picture') ?: null;
    }
}
