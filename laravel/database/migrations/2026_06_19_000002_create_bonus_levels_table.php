<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bonus_levels', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->decimal('required_points', 15, 2);
            $table->string('reward_name', 255);
            $table->text('reward_description')->nullable();
            $table->string('image', 255)->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bonus_levels');
    }
};
