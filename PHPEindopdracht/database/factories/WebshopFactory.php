<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Webshop>
 */
class WebshopFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'adres' => $this->faker->streetAddress(),
            'place' => $this->faker->city(),
            'postalcode' => $this->faker->postcode(),
        ];
    }
}
