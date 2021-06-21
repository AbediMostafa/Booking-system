<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id('id');
            $table->integer('amount');
            $table->timestamp('started_at', $precision = 0);
            $table->timestamp('ended_at', $precision = 0);
            $table->foreignId('room_id')->constrained('rooms');
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
        Schema::dropIfExists('discounts');
    }
}
