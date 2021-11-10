<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClosedHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('closed_hours', function (Blueprint $table) {
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');
            $table->foreignId('hour_id')->constrained('hours')->onDelete('cascade');
            $table->foreignId('day_id')->constrained('days')->onDelete('cascade');
            $table->primary(['room_id', 'hour_id', 'day_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('closed_hours');
    }
}
