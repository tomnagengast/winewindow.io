<?php

use App\Models\Bottle;
use App\Models\User;

beforeAll(function () {
    //
});

it('can be followed and unfollowed', function () {
    $this->bottle = Bottle::factory()->create();
    $this->user = User::factory()->withPersonalTeam()->create();
    actingAs($this->user);

    $this->bottle->follow();
    expect($this->user->currentTeam->followedBottles()->count())
        ->toBe(1);

    $this->bottle->unfollow();
    expect($this->user->currentTeam->followedBottles()->count())
        ->toBe(0);
});

it('a user is notified when a bottle they follow changes rating', function () {
    // https://laracasts.com/series/lets-build-a-forum-with-laravel/episodes/56
})->skip();
