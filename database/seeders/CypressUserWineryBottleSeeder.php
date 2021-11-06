<?php

namespace Database\Seeders;

use App\Models\Bottle;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;

class CypressUserWineryBottleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory()->create();
        $cellar = Team::factory()->asCellar()->create(['user_id' => $user->id]);
        $winery = Team::factory()->asWinery()->create(['user_id' => $user->id]);
        Bottle::factory()->count(10)->for($winery)->create();
    }
}
