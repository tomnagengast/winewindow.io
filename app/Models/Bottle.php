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

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function collections()
    {
        return $this->belongsToMany(Bottle::class);
    }
}
