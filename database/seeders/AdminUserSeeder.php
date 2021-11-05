<?php

namespace Database\Seeders;

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
                'is_frozen' => 0,
            ]
        )->create();

    }
}
