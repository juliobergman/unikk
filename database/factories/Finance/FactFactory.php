<?php

namespace Database\Factories\finance;

use App\Models\finance\Fact;
use Illuminate\Database\Eloquent\Factories\Factory;

class FactFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Fact::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => $this->faker->dateTimeBetween('-7 months', '+7 months'),
            'code_id' => $this->faker->numberBetween(1,93),
            'report_id' => $this->faker->numberBetween(1,2),
            'company_id' => 1,
            'user_id' => 1,
            'amount' => $this->faker->numberBetween(1000, 2000),
        ];
    }
}
