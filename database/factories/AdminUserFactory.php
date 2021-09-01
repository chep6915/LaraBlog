<?php

namespace Database\Factories;

use App\Models\adminUser;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class AdminUserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = adminUser::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'account' => $this->faker->unique()->regexify('[A-Za-z0-9]{' . mt_rand(4, 20) . '}'),
            'name' => $this->faker->name(),
            'admin_user_group_id' => $this->faker->numberBetween(1, 6),
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => Hash::make(env("TEST_PASSWORD")), // password
            'admin_user_last_ip' => $this->faker->ipv4,
            'last_update_admin_user_id' => 1,
            'is_frozen' => $this->faker->numberBetween(0, 1),
        ];
    }
}
