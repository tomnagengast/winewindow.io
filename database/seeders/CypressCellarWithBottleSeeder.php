<?php

namespace Database\Seeders;

use App\Models\Bottle;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;

class CypressCellarWithBottleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // logged in user
        $cellarUser = User::factory()->withPersonalTeam()->create(['email' => 'cellar@example.com']);

        // winery user with winery
        $wineryUser = User::factory()->withPersonalTeam()->create(['email' => 'winery@example.com']);
        $winery = Team::factory()->asWinery()->create(['user_id' => $wineryUser->id]);

        // unfollowed winery bottle
        Bottle::factory()->for($winery)->create(['vintage' => '1900', 'varietal' => 'A Super blend']);

        // followed winery bottles
        $bottles = Bottle::factory()->count(10)->for($winery)->create();
        $bottles->each(function ($bottle) use ($cellarUser) {
                $bottle->followers()->save($cellarUser->currentTeam);
        });
    }
}
