<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bottle extends Model
{
    use HasFactory;

    protected $casts = [
        'vintage' => 'integer',
    ];

    protected $guarded = [];

     protected $with = ['team'];

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
