<?php

namespace Database\Factories;

use App\Models\UserTaxi;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserTaxiFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserTaxi::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $carPrice = [
            120000,
            150000,
            160000,
            190000,
            200000,
            220000,
            430000,
            350000,
            550000,
            300000,
        ];
        $i = rand(1, count($carPrice));
        return [
            'taxi_id' => $i,
            'user_id' => $this->faker->numberBetween(1, 10),
            'color_id' => $this->faker->numberBetween(1, 3),
            'price' => $carPrice[$i-1],
        ];
    }
}
