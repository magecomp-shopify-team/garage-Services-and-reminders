<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tables = [
            'users', 'customers', 'vehicles', 'job_cards', 'services', 
            'spare_parts', 'invoices', 'payments', 'service_reminders', 'mechanics'
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $t) {
                $t->foreignId('workshop_id')->nullable()->constrained()->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        $tables = [
            'users', 'customers', 'vehicles', 'job_cards', 'services', 
            'spare_parts', 'invoices', 'payments', 'service_reminders', 'mechanics'
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $t) {
                $t->dropForeign(['workshop_id']);
                $t->dropColumn('workshop_id');
            });
        }
    }
};
