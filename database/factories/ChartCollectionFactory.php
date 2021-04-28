<?php

namespace Database\Factories;

use App\Models\ChartCollection;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChartCollectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ChartCollection::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'company_id'=> 1,
            'name' => $this->faker->sentence(3),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
