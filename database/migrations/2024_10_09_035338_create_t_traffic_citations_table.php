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
        Schema::create('t_traffic_citations', function (Blueprint $table) {
            $table->id();
            $table->string('plate_number')->unique();
            $table->string('violator_name');
            $table->string('address');
            $table->date('date');
            $table->string('municipal_ordinance_number');
            $table->string('specific_offense');
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_traffic_citations');
    }
};
