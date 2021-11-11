<?php

namespace Database\Seeders;

use App\Enums\AdminUser\AdminUserEnablePasswordLoginType;
use App\Enums\AdminUser\AdminUserFrozenType;
use App\Models\AdminUser;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AdminUser::factory(
            [
                "account" => env("TEST_ACCOUNT"),
                "email" => env("TEST_EMAIL"),
                "name" => env("TEST_GIVEN_NAME").' '.env("TEST_FAMILY_NAME"),
                "given_name" => env("TEST_GIVEN_NAME"),
                "family_name" => env("TEST_FAMILY_NAME"),
                "nickname" => env("TEST_NICKNAME"),
                'admin_user_group_id' => 1,
                'locale' => 'zh-TW',
                'enable_password_login' => AdminUserEnablePasswordLoginType::EnablePasswordLogin,
                'is_frozen' => AdminUserFrozenType::NotFrozen,
            ]
        )->create();

    }
}
