<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIdeasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ideas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('headline');
            $table->text('description');
            $table->string('image');
            $table->string('video')->nullable();
            $table->decimal('price', 5, 2);
            $table->integer('currency_id')->unsigned();
            $table->text('url');
            $table->text('address');
            $table->string('button_buy_text');
            $table->string('button_buy_for_me_text');
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
        Schema::dropIfExists('ideas');
    }
}
