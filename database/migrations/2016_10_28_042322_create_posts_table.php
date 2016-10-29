<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 170);
            $table->text('content');
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categories')
              ->onDelete('cascade');
            $table->integer('status')->default(1);
            $table->string('seo_title', 70);
            $table->string('seo_description', 170);
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
        Schema::dropIfExists('posts');
    }
}
