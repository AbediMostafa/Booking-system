<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id('id');
            $table->string('name',255);
            $table->string('description',255);
            $table->string('image',255);
            $table->string('banner',255);
            $table->integer('price');
            $table->integer('max_person');
            $table->integer('min_person');
            $table->integer('game_time');
            $table->enum('hardness',[1,2,3,4,5]);
            $table->enum('type',['special', 'new']);
            $table->string('phone',255);
            $table->string('mobile',255);
            $table->string('district',100);
            $table->string('address',255);
            $table->foreignId('collection_id')->constrained('collections');
            $table->foreignId('city_id')->constrained('cities');
            $table->enum('status',['disable','enable']);
            $table->enum('is_special',['false','true']);
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
        Schema::dropIfExists('rooms');
    }
}
