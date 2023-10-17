<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'name' => $this->faker->name(),
            'address' => $this->faker->address(),
            'address_detail' => $this->faker->streetAddress(),
            'email' => $this->faker->email(),
            'phone_number' => $this->faker->e164PhoneNumber(),
            'zip_code' => '12420',
            'zone_code' => $this->faker->countryCode(),
        ];
    }
}
