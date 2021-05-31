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
            $table->foreignId('room_id')->constrained('rooms');
            $table->enum('scary',[1,2,3,4,5]);
            $table->enum('design',[1,2,3,4,5]);
            $table->enum('fun_charm',[1,2,3,4,5]);
            $table->enum('creativity',[1,2,3,4,5]);
            $table->enum('puzzle',[1,2,3,4,5]);
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
