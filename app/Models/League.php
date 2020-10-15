<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'sport_id',
        'unique_id',
        'status'
    ];

    public function sport(){
        return $this->belongsTo('App\Models\Sport');
    }
    
    public function league_entries(){
        return $this->hasMany('App\Models\League_entry')->orderBy('score', 'desc');
    }

    public function matches(){
        return $this->hasMany('App\Models\Match')->orderBy('id', 'desc')->limit(10);
    }

    public function invitations(){
        return $this->hasMany('App\Models\Invitation');
    }

}
