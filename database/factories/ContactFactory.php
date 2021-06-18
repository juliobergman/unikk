<?php

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contact::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'name' => $this->faker->name(),
            'company' => $this->faker->company(),
            'email' => $this->faker->email(),
            'phone' => $this->faker->e164PhoneNumber(),
            'address' => $this->faker->address(),
            'profile_pic' => 'factory/stock/user-profile.jpg',
        ];
    }
}
