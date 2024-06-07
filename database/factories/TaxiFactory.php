<?php

namespace Database\Factories;

use App\Models\Taxi;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaxiFactory extends Factory
{
    protected $model = Taxi::class;

    public function definition(): array
    {

        $carNames = [
            'Toyota Corolla'        => 120000,
            'Honda Civic'           => 150000,
            'Mazda3'                => 160000,
            'Volkswagen Golf'       => 190000,
            'Ford Mustang'          => 200000,
            'Chevrolet Camaro'      => 220000,
            'Dodge Challenger'      => 430000,
            'BMW 3 Series'          => 350000,
            'Mercedes-Benz C-Class' => 550000,
            'Audi A4'               => 300000,
        ];

        return [
            'name'  => $this->faker->unique()->randomElement(array_keys($carNames)),
            'key'   => $this->faker->unique()->word,
            'price' => $this->faker->unique()->randomElement($carNames),
            'color_id' => $this->faker->numberBetween(1, 3),
        ];
    }
}
