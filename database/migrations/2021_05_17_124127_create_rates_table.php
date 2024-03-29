<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rates', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');;
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('scariness',[1,2,3,4,5]);
            $table->enum('room_decoration',[1,2,3,4,5]);
            $table->enum('hobbiness',[1,2,3,4,5]);
            $table->enum('creativeness',[1,2,3,4,5]);
            $table->enum('mysteriness',[1,2,3,4,5]);
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rates');
    }
}
