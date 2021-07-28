<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mediaables', function (Blueprint $table) {
            $table->integer('media_id');
            $table->enum('place', ['front', 'banner', 'other', 'video']);
            $table->integer('mediaable_id');
            $table->string('mediaable_type')->nullable();
            $table->timestamps();

            $table->primary(['media_id', 'place', 'mediaable_id', 'mediaable_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mediaables');
    }
}
