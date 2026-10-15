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
        Schema::create('power_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('power_meter_id')
                  ->constrained('power_meters')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            
            $table->float('voltage', 8, 2);
            $table->float('current', 8, 2);
            $table->float('power', 10, 2);
            $table->float('total_kwh', 10, 2);
            $table->timestamp('recorded_at');
            $table->timestamps();
            $table->index(['power_meter_id', 'recorded_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('power_data');
    }
};
