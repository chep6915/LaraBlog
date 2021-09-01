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
                "name" => env("TEST_NAME"),
                'admin_user_group_id' => 1,
                'is_frozen' => 0,
            ]
        )->create();
    }
}
