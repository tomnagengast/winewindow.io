<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Bottle extends Model
{
    use HasFactory;
    use Sluggable;

    protected $casts = [
        'vintage' => 'integer',
    ];

    protected $fillable = [
        'vintage',
        'varietal',
        'rating',
        'description',
        'team_id',
        'winery',
        'slug',
    ];

    protected $with = ['team'];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['vintage', 'varietal'],
                'unique' => false,
                'onUpdate' => true,
            ]
        ];
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function collections()
    {
        return $this->belongsToMany(Bottle::class);
    }

    public function followers()
    {
        return $this->belongsToMany(Team::class);
    }

    public function follow()
    {
        return $this->followers()->save(auth()->user()->currentTeam);
    }

    public function unfollow()
    {
        return $this->followers()->detach(auth()->user()->currentTeam);
    }
}
