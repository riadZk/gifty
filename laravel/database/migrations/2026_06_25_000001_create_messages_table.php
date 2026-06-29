<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('message_key')->unique();
            $table->string('title', 150);
            $table->text('body');
            $table->json('channels');                       // ['push','mail','whatsapp']
            $table->foreignId('sent_by')->nullable()->constrained('users')->nullOnDelete();
            $table->unsignedInteger('recipients_count')->default(0);
            $table->unsignedInteger('delivered_count')->default(0);
            $table->unsignedInteger('failed_count')->default(0);
            $table->enum('status', ['queued', 'sent', 'partial', 'failed'])->default('queued');
            $table->timestamps();

            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
