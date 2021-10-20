<?php

namespace Database\Factories;

use App\Models\Bottle;
use Illuminate\Database\Eloquent\Factories\Factory;

class BottleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Bottle::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'winery' => $this->faker->company,
            'vintage' => $this->faker->year('now'), // ->unique()
            'varietal' => $this->faker->randomElement(['Syrah', 'Merlot', 'Cabernet Sauvignon', 'Fiano', 'Chardonnay']),
            'description' => $this->faker->paragraph(4),
            'rating' => $this->faker->numberBetween(1, 5),
        ];
    }
}
