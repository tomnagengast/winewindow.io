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
        $tom = User::factory()
            ->withPersonalTeam()
            ->create([
                'name' => 'Tom Nagengast',
                'email' => 'tnagengast@gmail.com'
            ]);

        $bajka = Team::factory()
            ->asWinery()
            ->create([
                'user_id' => $tom->id,
                'name' => 'Bajka Wine Company'
            ]);

        $csvFile = fopen(base_path('database/data/bajka_bottles.csv'), 'r');
        $firstline = true;
        while (($row = fgetcsv($csvFile)) !== false) {
            if (!$firstline) {
                Bottle::factory()
                    ->for($bajka)
                    ->create([
                        'varietal' => $row[0],
                        'vintage' => $row[1],
                        'rating' => $row[2],
                        'winery' => $bajka->name,
                    ]);
            }
            $firstline = false;
        }
        fclose($csvFile);

        $beth = User::factory()->withPersonalTeam()->create([
            'name' => 'Beth Nagengast',
            'email' => 'beth@cinquaincellars.com'
        ]);

        $cinquain = Team::factory()
            ->asWinery()
            ->hasCollections(4)
            ->create(['user_id' => $beth->id, 'name' => 'Cinquain Cellars']);

        $csvFile = fopen(base_path('database/data/cinquain_cellars_bottles.csv'), 'r');
        $firstline = true;
        while (($row = fgetcsv($csvFile)) !== false) {
            if (!$firstline) {
                Bottle::factory()
                    ->for($cinquain)
                    ->create([
                        'varietal' => $row[0],
                        'vintage' => $row[1],
                        'rating' => $row[2],
                        'winery' => $cinquain->name,
                    ]);
            }
            $firstline = false;
        }
        fclose($csvFile);

        $cinquain->collections->each(function ($collection, $key) use ($cinquain) {
            $bottleIds = $cinquain->ownedBottles()->take(rand(3, 10))->pluck('id');
            $collection->bottles()->attach($bottleIds);
        });

        $bajka->ownedBottles()->take(2)->get()->each(function ($bottle) use ($tom) {
            $bottle->followers()->save($tom->currentTeam);
        });

        $cinquain->ownedBottles()->take(4)->get()->each(function ($bottle) use ($tom) {
            $bottle->followers()->save($tom->currentTeam);
        });

        $bajka->users()->attach($beth, ['role' => 'admin']);
        $cinquain->users()->attach($tom, ['role' => 'admin']);
    }
}
