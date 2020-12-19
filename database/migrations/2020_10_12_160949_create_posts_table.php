<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->integer('user_id');
            $table->integer('category_id');
         //   $table->Text('category_name');
         $table->Text('title')->nullable();
            $table->Text('Sub_Category_name');
            $table->longText('Description')->nullable();
            $table->integer('price')->nullable();
            $table->Text('location')->nullable();
            $table->json('pro')->nullable();
            $table->integer('rate')->nullable();
            $table->longText('main_img')->nullable();

///////////////////////////////////////////
            $table->softDeletes();
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
