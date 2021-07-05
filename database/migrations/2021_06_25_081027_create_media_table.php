<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('display_name');
            $table->string('store_name')->nullable();
            $table->string('path');
            $table->enum('media_of',['city', 'collection', 'post', 'room','genre', 'specific_media', 'other']);
            $table->enum('type',['image','video']);
            $table->enum('place',['front','banner','other','video']);
            $table->integer('mediaable_id')->unsigned()->index()->nullable();
            $table->string('mediaable_type')->nullable();
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
        Schema::dropIfExists('media');
    }
}
