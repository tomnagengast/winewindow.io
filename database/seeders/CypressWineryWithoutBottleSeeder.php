<?php

namespace Database\Seeders;

use App\Models\Bottle;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;

class CypressWineryWithoutBottleSeeder extends Seeder
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
        $winery = Team::factory()->asWinery()->create(['user_id' => $user->id]);
//        Bottle::factory()->count(10)->for($winery)->create();
//        Bottle::factory()->for($winery)->create(['vintage' => '1900', 'varietal' => 'A Super blend']);
        $user->switchTeam($winery);
    }
}
