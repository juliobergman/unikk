<?php

namespace Database\Factories;

use App\Models\UserData;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserDataFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserData::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'job_title' => $this->faker->jobTitle(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
        ];
    }
}
