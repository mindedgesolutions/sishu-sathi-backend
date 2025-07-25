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
        Schema::create('child_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('child_master_id')->constrained('child_masters')->onDelete('cascade');
            $table->boolean('below_18_above_35')->nullable();
            $table->boolean('medical_condition')->nullable();
            $table->boolean('take_suppliments')->nullable();
            $table->boolean('complications_pregnancy')->nullable();
            $table->boolean('assisted_delivery')->nullable();
            $table->boolean('hospital_born')->nullable();
            $table->boolean('before_37')->nullable();
            $table->boolean('less_than_two_and_half')->nullable();
            $table->boolean('apgar_below_7')->nullable();
            $table->boolean('complications_birth')->nullable();
            $table->string('cry_at_birth')->nullable();
            $table->string('delay_time')->nullable();
            $table->boolean('nicu_stay')->nullable();
            $table->boolean('breastfeeding_within_1')->nullable();
            $table->boolean('jaundice_other')->nullable();
            $table->boolean('hospitalised_year_1')->nullable();
            $table->boolean('seizures')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('child_details');
    }
};
