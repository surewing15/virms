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
        Schema::create('t_vehicle_impoundings', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('vehicle_number'); // e.g., license plate number
            $table->string('owner_name'); // Vehicle owner's name
            $table->string('vehicle_type'); // Car, motorcycle, etc.
            $table->foreignId('violation_id')->constrained('t_entries_violations')->onDelete('cascade'); // Foreign key to violations
            $table->date('date_of_impounding'); // Date the vehicle was impounded
            $table->string('reason_for_impounding')->nullable(); // Reason for impounding, if any
            $table->decimal('fine_amount', 10, 2)->nullable(); // Penalty/fine for impounding
            $table->date('release_date')->nullable(); // Release date (optional)
            $table->timestamps(); // Created at & updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_vehicle_impoundings');
    }
};
