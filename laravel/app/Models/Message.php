<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Message extends Model
{
    const STATUS_QUEUED  = 'queued';
    const STATUS_SENT    = 'sent';
    const STATUS_PARTIAL = 'partial';
    const STATUS_FAILED  = 'failed';

    protected $fillable = [
        'message_key',
        'title',
        'body',
        'channels',
        'sent_by',
        'recipients_count',
        'delivered_count',
        'failed_count',
        'status',
    ];

    protected $casts = [
        'channels'         => 'array',
        'recipients_count' => 'integer',
        'delivered_count'  => 'integer',
        'failed_count'     => 'integer',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (self $model): void {
            if (empty($model->message_key)) {
                do {
                    $key = 'MSG-' . strtoupper(Str::random(8));
                } while (static::where('message_key', $key)->exists());

                $model->message_key = $key;
            }
        });
    }

    // ── Relationships ─────────────────────────────────────────────────────────

    public function recipients(): HasMany
    {
        return $this->hasMany(MessageRecipient::class);
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sent_by');
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    /**
     * Recompute aggregate counts and overall status from recipient rows.
     */
    public function recomputeStatus(): void
    {
        $delivered = $this->recipients()->where('status', MessageRecipient::STATUS_SENT)->count();
        $failed    = $this->recipients()->where('status', MessageRecipient::STATUS_FAILED)->count();

        $status = match (true) {
            $delivered === 0 && $failed > 0 => self::STATUS_FAILED,
            $failed > 0                     => self::STATUS_PARTIAL,
            default                         => self::STATUS_SENT,
        };

        $this->update([
            'delivered_count' => $delivered,
            'failed_count'    => $failed,
            'status'          => $status,
        ]);
    }
}
