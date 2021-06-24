<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id('id');
            $table->string('body',255);
            $table->integer('commentable_id')->unsigned()->index();
            $table->string('commentable_type');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('parent_id')->nullable()->constrained('comments');
            $table->integer('up_rate');
            $table->integer('down_rate');
            $table->enum('status', ['disagree', 'agree']);
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
        Schema::dropIfExists('comments');
    }
}
