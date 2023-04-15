<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $fname = $this->faker->firstName;
        $lname = $this->faker->lastName;
        return [
            'name' => $this->faker->name,
            'email' => $fname.$lname.'@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('Admin@123'),//'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'organization_id' => 2,
            'role_id' => 3,
        ];

    }
    // For creating workers
    public function stateMethod(){
        return $this->state(
            [
                'role_id' => 4,
            ]
        );
    }
}
