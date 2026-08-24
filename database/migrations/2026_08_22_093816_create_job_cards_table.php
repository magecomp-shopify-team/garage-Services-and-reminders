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
        Schema::create('job_cards', function (Blueprint $table) {
            $table->id();
            $table->string('job_number')->unique();
            $table->foreignId('customer_id')->constrained();
            $table->foreignId('vehicle_id')->constrained();
            $table->foreignId('mechanic_id')->nullable()->constrained();
            $table->text('complaint')->nullable();
            $table->text('inspection_notes')->nullable();
            $table->integer('current_km')->nullable();
            $table->decimal('estimated_amount', 10, 2)->nullable();
            $table->string('status')->default('Pending');
            $table->date('received_date')->nullable();
            $table->date('completed_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_cards');
    }
};
