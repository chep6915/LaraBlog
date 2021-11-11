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
            $table->integer('category_id')->comment('分類ID');
            $table->string('title')->comment('標題');
            $table->string('sub_title')->comment('副標題');
            $table->integer('tag_id')->comment('標籤ID');
            $table->string('content')->comment('內文');
            $table->timestamp('publish_date')->comment('發布日期');
            $table->tinyInteger('public_type')->comment('文章開放設定(0:開放,1:密碼保護,2:密碼保護並有提示語,3:好友限定)');
            $table->string('passwordHint')->comment('密碼提示語');
            $table->integer('reply_type')->comment('文章回應設定(0:允許,1:不允許,2:好友限定)');
            $table->tinyInteger('is_top')->comment('文章置頂(0:一般,1:置頂,2:好友限定)');
            $table->integer('sync_publish_id')->comment('同步發布至');
            $table->tinyInteger('status')->comment('文章狀態(0:已發布,1:未發布,2:草稿)');
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
