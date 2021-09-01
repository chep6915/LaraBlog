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
            $table->integer('admin_user_id');
            $table->integer('category_id');
            $table->string('title');
            $table->string('sub_title');
            $table->integer('tag_id');
            $table->string('content');
            $table->timestamp('publish_date');
            $table->integer('public_type');
            $table->integer('reply_type');
            $table->integer('is_top');
            $table->integer('sync_publish_id');
            $table->integer('status');
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
