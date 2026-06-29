<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loyalty_settings', function (Blueprint $table) {
            $table->id();
            $table->string('currency', 10)->default('MAD');
            $table->decimal('amount_value', 10, 2);
            $table->decimal('points_value', 10, 2);
            $table->boolean('annual_reset')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loyalty_settings');
    }
};
