<?php

namespace App\Jobs;

use App\Models\Bottle;
use App\Notifications\BottleWasUpdated;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyBottleUpdated implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $bottle;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Bottle $bottle)
    {
        $this->bottle = $bottle;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $followingUsers = collect();

        $this->bottle->followers()->each(function ($cellar) use($followingUsers) {
            return $cellar->allUsers()->each(function ($user) use($followingUsers) {
                if (!$followingUsers->contains($user)) {
                    $followingUsers->push($user);
                }
            });
        });

        info($followingUsers->pluck('email')->toJson());

        $followingUsers->each(function ($user) {
            $user->notify(new BottleWasUpdated($this->bottle));
        });
    }
}
