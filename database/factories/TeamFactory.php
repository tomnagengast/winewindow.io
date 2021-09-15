<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Team::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->company(),
            'user_id' => User::factory(),
            'personal_team' => true,
            'type' => $this->faker->randomElement(['cellar', 'winery'])
        ];
    }

    public function asWinery()
    {
        return $this->state(function (array $attributes) {
            return ['type' => 'winery'];
        });
    }

    public function asCellar()
    {
        return $this->state(function (array $attributes) {
            return ['type' => 'cellar'];
        });
    }
}
