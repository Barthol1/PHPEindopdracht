<?php

namespace Database\Factories;

use App\enum\PackageStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Package>
 */
class PackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->ean13(),
            'status' => PackageStatus::AANGEMELD,
            'sender_name' => $this->faker->name(),
            'sender_adres' => $this->faker->streetAddress(),
            'sender_city' => $this->faker->city(),
            'sender_postalcode' => $this->faker->postcode(),
            'receiver_name' => $this->faker->name(),
            'receiver_adres' => $this->faker->streetAddress(),
            'receiver_city' => $this->faker->city(),
            'receiver_postalcode' => $this->faker->postcode(),
            'users_id' => 1
        ];
    }
}
