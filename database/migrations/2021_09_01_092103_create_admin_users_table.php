<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_users', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('系統用户ID');
            $table->string('avatar_original')->comment('系統用戶原始頭像')->nullable();
            $table->string('avatar')->comment('系統用戶頭像')->nullable();
            $table->string('picture')->comment('系統用戶照片')->nullable();
            $table->string('account')->comment('系統用戶帳號');
            $table->string('name')->comment('系統用戶名稱');
            $table->string('given_name')->comment('名字');
            $table->string('family_name')->comment('姓氏');
            $table->string('nick_name')->comment('系統用戶暱稱');
            $table->integer('admin_user_group_id')->comment('系統用戶群組ID');
            $table->string('email', 150)->comment('信箱');
            $table->timestamp('email_verified_at')->comment('信箱認證時間')->nullable();
            $table->string('password')->comment('系統用戶密碼');
            $table->string('admin_user_last_ip')->comment('系統用戶最後登入IP')->nullable();
            $table->integer('last_update_admin_user_id')->comment('最後編輯系統用戶ID');
            $table->string('admin_user_locale')->comment('系統用戶地區');
            $table->integer('Google_id')->comment('GoogleId')->nullable();
            $table->integer('is_frozen')->comment('是否被凍結(0:未被凍結,1:被凍結)')->default(0);
            $table->timestamps();

            //軟刪
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_users');
    }
}
