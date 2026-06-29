<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MessageRecipient extends Model
{
    const STATUS_PENDING = 'pending';
    const STATUS_SENT    = 'sent';
    const STATUS_FAILED  = 'failed';

    protected $fillable = [
        'message_id',
        'client_id',
        'channel',
        'status',
        'error',
        'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    // ── Relationships ─────────────────────────────────────────────────────────

    public function message(): BelongsTo
    {
        return $this->belongsTo(Message::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    public function markSent(): void
    {
        $this->update([
            'status'  => self::STATUS_SENT,
            'sent_at' => now(),
        ]);
    }

    public function markFailed(?string $error = null): void
    {
        $this->update([
            'status' => self::STATUS_FAILED,
            'error'  => $error,
        ]);
    }
}
