<?php

namespace Database\Seeders;

use App\Models\Bottle;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Laravel\Jetstream\Jetstream;

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
        $tom = User::factory()->create([
            'name' => 'Tom Nagengast',
            'email' => 'tnagengast@gmail.com'
        ]);

        // default teams
        Team::factory()->asCellar()->create(['user_id' => $tom->id, 'name' => 'Tom\'s Team']);
        $bajka = Team::factory()
            ->asWinery()
//            ->has(Bottle::factory()->count(15)->state(function (array $attributes, Team $team) {
//                return ['winery' => $team->name];
//            }))
            ->create(['user_id' => $tom->id, 'name' => 'Bajka Wine Company']);

        $csvFile = fopen(base_path('database/data/bajka_bottles.csv'), 'r');
        $firstline = true;
        while (($data = fgetcsv($csvFile)) !== false) {
            if (!$firstline) {
                Bottle::factory()->for($bajka)
                    ->create([
                        'varietal' => $data['0'],
                        'vintage' => $data['1'],
                        'rating' => $data['2'],
                        'winery' => 'Cinquain Cellars'
                    ]);
            }
            $firstline = false;
        }
        fclose($csvFile);





        $cinquain = Team::factory()
            ->asWinery()
            ->hasCollections(4)
            ->create(['user_id' => $tom->id, 'name' => 'Cinquain Cellars']);

        $csvFile = fopen(base_path('database/data/cinquain_cellars_bottles.csv'), 'r');
        $firstline = true;
        while (($data = fgetcsv($csvFile)) !== false) {
            if (!$firstline) {
                Bottle::factory()->for($cinquain)
                    ->create([
                        'varietal' => $data['0'],
                        'vintage' => $data['1'],
                        'rating' => $data['2'],
                        'winery' => 'Cinquain Cellars'
                    ]);
            }
            $firstline = false;
        }
        fclose($csvFile);


        // default colections
        $cinquain->collections->each(function ($collection, $key) use ($cinquain) {
            $bottleIds = $cinquain->bottles->take(rand(3, 10))->pluck('id');
            $collection->bottles()->attach($bottleIds);
        });

        // add cinquain for examples
        $beth = User::factory()->create([
            'name' => 'Beth Nagengast',
            'email' => 'beth@cinquaincellars.com'
        ]);
        Team::factory()->asCellar()->create(['user_id' => $beth->id, 'name' => 'Beth\'s Team']);
        $cinquain->users()->attach(
            $beth, ['role' => 'admin']
        );
        $bajka->users()->attach(
            $beth, ['role' => 'admin']
        );
    }
}
