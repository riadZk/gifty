<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('message_recipients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('message_id')->constrained()->cascadeOnDelete();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->string('channel');  // push | mail | whatsapp
            $table->enum('status', ['pending', 'sent', 'failed'])->default('pending');
            $table->text('error')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            $table->unique(['message_id', 'client_id', 'channel']);
            $table->index(['client_id', 'status']);
            $table->index('channel');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('message_recipients');
    }
};
