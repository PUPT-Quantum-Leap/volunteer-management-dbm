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
        Schema::create('org_chart', function (Blueprint $table) {
            $table->id();
            $table->string('objective');
            $table->string('menu');
            $table->date('date');
            $table->integer('volunteers');
            $table->string('planning');
            $table->string('purchasing');
            $table->string('mwc_coordinator');
            $table->string('safety_emergency');
            $table->string('mobile_kitchen');
            $table->string('am_distribution');
            $table->string('pm_distribution');
            $table->json('teams');
            $table->json('kitchen_truck');
            $table->json('food_prep');
            $table->json('volunteer_care');
            $table->json('wash_cleanup');
            $table->json('inventory');
            $table->json('meal_breakdown');
            $table->json('vehicles');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('org_chart');
    }
};
