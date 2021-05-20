<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Company;
use App\Models\CompanyData;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;

class CompanyDataFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CompanyData::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'address' => $this->faker->address(),
            'city' => $this->faker->city(),
            'country' => strtolower($this->faker->countryCode()),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->companyEmail(),
            'website' => $this->faker->domainName(),
            'info' => $this->faker->paragraph(10),
            'logo' => 'https://cdn.vuetifyjs.com/images/parallax/material.jpg',
        ];
    }
}
