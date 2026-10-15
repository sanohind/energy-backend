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
        Schema::create('power_meters', function (Blueprint $table) {
            $table->id();
            $table->integer('slave_id')->unique();
            $table->string('name', 100);
            $table->float('max_voltage')->default(250);
            $table->float('max_current')->default(100);
            $table->float('max_power')->default(25000);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('power_meters');
    }
};
