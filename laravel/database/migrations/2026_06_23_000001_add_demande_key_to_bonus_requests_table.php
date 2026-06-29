<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bonus_requests', function (Blueprint $table) {
            $table->string('demande_key', 20)->unique()->nullable()->after('id');
        });

        // Backfill existing rows with a unique key
        \DB::table('bonus_requests')->whereNull('demande_key')->orderBy('id')->each(function ($row) {
            do {
                $key = 'DB-' . strtoupper(Str::random(8));
            } while (\DB::table('bonus_requests')->where('demande_key', $key)->exists());

            \DB::table('bonus_requests')->where('id', $row->id)->update(['demande_key' => $key]);
        });

        // Make the column non-nullable after backfill (no unique() — already added above)
        Schema::table('bonus_requests', function (Blueprint $table) {
            $table->string('demande_key', 20)->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('bonus_requests', function (Blueprint $table) {
            $table->dropUnique(['demande_key']);
            $table->dropColumn('demande_key');
        });
    }
};
