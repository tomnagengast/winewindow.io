<?php

namespace Database\Seeders;

use App\Models\Bottle;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * https://laravel.com/docs/8.x/seeding
     *
     * @return void
     */
    public function run()
    {

         User::factory()->count(50)->create();

        // default user
        $user = User::factory()->create([
            'name' => 'Tom Nagengast',
            'email' => 'tnagengast@gmail.com'
        ]);

        // default teams
        $cellar = Team::factory()->asCellar()->create(['user_id' => $user->id, 'name' => 'Tom\'s Team']);
        Team::factory()->asWinery()
            ->has(Bottle::factory()->count(15)->state(function (array $attributes, Team $team) {
                return ['winery' => $team->name];
            }))
            ->create(['user_id' => $user->id, 'name' => 'Bajka Wine Company']);

        $team = Team::factory()->asWinery()->hasCollections(4)
            ->has(Bottle::factory()->count(32)->state(function (array $attributes, Team $team) {
                return ['winery' => $team->name];
            }))
            ->create(['user_id' => $user->id, 'name' => 'Cinquain Cellars']);

        // default colections
        $team->collections->each(function ($collection, $key) use ($team) {
            $bottleIds = $team->bottles->take(rand(3, 10))->pluck('id');
            $collection->bottles()->attach($bottleIds);
        });

    }
}
