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
        Schema::create('service_reminders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained();
            $table->foreignId('vehicle_id')->constrained();
            $table->foreignId('job_card_id')->nullable()->constrained();
            $table->date('last_service_date')->nullable();
            $table->date('next_service_date')->nullable();
            $table->integer('last_service_km')->nullable();
            $table->integer('next_service_km')->nullable();
            $table->integer('reminder_before_days')->default(3);
            $table->string('status')->default('Upcoming');
            $table->text('notes')->nullable();
            $table->string('created_by')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_reminders');
    }
};
