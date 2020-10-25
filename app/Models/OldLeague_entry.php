<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OldLeague_entry extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'league_id',
        'played',
        'win',
        'loose',
        'draw',
        'goals_for',
        'goals_against',
        'max_score',
        'min_score',
        'score',
        'place',
        'match_id'

    ];


    public function league(){
        return $this->belongsTo('App\Models\League');
    }



    public function user(){
        return $this->belongsTo('App\Models\User');
    }



    public function match(){
        return $this->belongsTo('App\Models\Match');
    }

}
