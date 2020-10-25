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
        return $this->belongsTo(Sport::class);
    }
    

    //laravel scope
    public function league_entries(){
        return $this->hasMany(League_entry::class)->orderBy('score', 'desc');
    }

    public function matches(){
        return $this->hasMany(Match::class)->orderBy('id', 'desc')->limit(10);
    }


}
