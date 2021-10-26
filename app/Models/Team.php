<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Jetstream\Events\TeamCreated;
use Laravel\Jetstream\Events\TeamDeleted;
use Laravel\Jetstream\Events\TeamUpdated;
use Laravel\Jetstream\Team as JetstreamTeam;
use Laravel\Scout\Searchable;

class Team extends JetstreamTeam
{
    use HasFactory;
    use Searchable;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'personal_team' => 'boolean',
    ];

    protected $guarded = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'personal_team',
        'type',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => TeamCreated::class,
        'updated' => TeamUpdated::class,
        'deleted' => TeamDeleted::class,
    ];

    public function isWinery()
    {
        return $this->type == 'winery';
    }

    public function shouldBeSearchable()
    {
        return $this->type == 'winery';
    }

    public function ownedBottles()
    {
        return $this->hasMany(Bottle::class);
    }

    public function followedBottles()
    {
        return $this->belongsToMany(Bottle::class);
    }

    public function collections()
    {
        return $this->hasMany(Collection::class);
    }
}
