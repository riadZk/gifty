<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();

            // Core identity (copied from accepted account_request)
            $table->string('company_name');
            $table->string('contact_name');
            $table->string('email')->unique();
            $table->string('phone', 30)->unique();
            $table->string('pcc_customer_code', 60)->nullable()->unique();

            // Authentication
            $table->string('password');
            $table->rememberToken();

            // Platform status
            $table->enum('status', ['active', 'inactive', 'blocked'])->default('active')->index();

            // Points balance (denormalized for fast reads)
            $table->decimal('points_balance', 12, 2)->default(0);

            $table->timestamps();

            $table->index('pcc_customer_code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
