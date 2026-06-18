<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Removes the legacy `account_requests` workflow.
     *
     * Clients are now created directly via /api/clients/register with
     * status = 'inactive'. An administrator activates them afterwards.
     */
    public function up(): void
    {
        // Drop the FK + column on clients (if present)
        if (Schema::hasColumn('clients', 'account_request_id')) {
            Schema::table('clients', function (Blueprint $table) {
                try {
                    $table->dropForeign(['account_request_id']);
                } catch (\Throwable $e) {
                    // FK may already be gone — ignore.
                }
                $table->dropColumn('account_request_id');
            });
        }

        // Drop the table itself
        Schema::dropIfExists('account_requests');
    }

    /**
     * No-op down: the account_requests feature has been intentionally removed.
     */
    public function down(): void
    {
        // Not reversible.
    }
};
