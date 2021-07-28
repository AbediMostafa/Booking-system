<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rooms', function (Blueprint $table) {

            $table->engine = 'InnoDB';

            $table->text('short_description')->nullable();

            $table->unsignedInteger('collection_id')->unsigned()->index()->nullable()->change();
            $table->unsignedInteger('city_id')->unsigned()->index()->nullable()->change();

            $table->foreign('collection_id')->references('id')->on('collections')->onDelete('set null');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
