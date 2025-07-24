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
        Schema::table('user_details', function (Blueprint $table) {
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
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_details', function (Blueprint $table) {
            $table->dropColumn([
                'below_18_above_35',
                'medical_condition',
                'take_suppliments',
                'complications_pregnancy',
                'assisted_delivery',
                'hospital_born',
                'before_37',
                'less_than_two_and_half',
                'apgar_below_7',
                'complications_birth',
                'cry_at_birth',
                'delay_time',
                'nicu_stay',
                'breastfeeding_within_1',
                'jaundice_other',
                'hospitalised_year_1',
                'seizures',
            ]);
        });
    }
};
