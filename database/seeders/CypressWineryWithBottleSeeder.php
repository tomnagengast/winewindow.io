<?php

namespace Database\Seeders;

use App\Models\Bottle;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;

class CypressWineryWithBottleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->withPersonalTeam()->create(['email' => 'cellar@example.com']);
        $user = User::factory()->withPersonalTeam()->create(['email' => 'winery@example.com']);
        $winery1 = Team::factory()->asWinery()->create(['user_id' => $user->id]);
        Bottle::factory()->count(10)->for($winery1)->create();
        $winery2 = Team::factory()->asWinery()->create(['user_id' => $user->id]);
        Bottle::factory()->count(10)->for($winery2)->create();
        Bottle::factory()->for($winery2)->create(['vintage' => '1900', 'varietal' => 'Super blend']);
        $user->switchTeam($winery2);
    }
}
