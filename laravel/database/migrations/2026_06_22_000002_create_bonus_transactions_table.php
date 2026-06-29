<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bonus_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->foreignId('bonus_request_id')->constrained()->cascadeOnDelete();
            $table->foreignId('bonus_level_id')->constrained()->cascadeOnDelete();
            $table->decimal('points_before', 15, 2);
            $table->decimal('points_used', 15, 2);
            $table->decimal('points_after', 15, 2);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bonus_transactions');
    }
};
