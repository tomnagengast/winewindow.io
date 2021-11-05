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

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Bottle $bottle)
    {
        $this->teams = $bottle->followers();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        dd($this->teams);
        $this->teams->each(function ($cellar) {
            $cellar->allUsers()->each(function ($user) {
                new BottleWasUpdated($this->bottle, $user);
            });
        });
    }
}
