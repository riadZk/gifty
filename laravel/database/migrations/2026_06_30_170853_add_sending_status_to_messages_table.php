<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Drop the old check constraint and add a new one that includes 'sending'
        DB::statement('ALTER TABLE messages DROP CONSTRAINT IF EXISTS messages_status_check');
        DB::statement("ALTER TABLE messages ADD CONSTRAINT messages_status_check CHECK (status IN ('queued','sending','sent','partial','failed'))");
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE messages DROP CONSTRAINT IF EXISTS messages_status_check');
        DB::statement("ALTER TABLE messages ADD CONSTRAINT messages_status_check CHECK (status IN ('queued','sent','partial','failed'))");
    }
};
