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
        Schema::table('volunteers', function (Blueprint $table) {
            $table->date('birthdate')->nullable()->change();
            $table->string('education')->nullable()->change();
            $table->text('availability')->nullable()->change();
            $table->string('emergency_name')->nullable()->change();
            $table->string('emergency_relation')->nullable()->change();
            $table->string('emergency_phone')->nullable()->change();
            $table->enum('lifegroup', ['yes', 'no'])->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('volunteers', function (Blueprint $table) {
            $table->date('birthdate')->nullable(false)->change();
            $table->string('education')->nullable(false)->change();
            $table->text('availability')->nullable(false)->change();
            $table->string('emergency_name')->nullable(false)->change();
            $table->string('emergency_relation')->nullable(false)->change();
            $table->string('emergency_phone')->nullable(false)->change();
            $table->enum('lifegroup', ['yes', 'no'])->nullable(false)->change();
        });
    }
};
