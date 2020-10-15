<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    use HasFactory;

    protected $fillable = [
        'league_id',
        'first_user_id',
        'second_user_id',
        'first_user_goals',
        'second_user_goals',
        'second_user_score',
        'first_user_score',
        'second_user_old_score',
        'first_user_old_score',
    ];

    public function league()
    {
        return $this->belongsTo('App\Models\League');
    }

    public function first_user(){
        return $this->belongsTo('App\Models\User', 'first_user_id');

    }

    public function second_user(){
        return $this->belongsTo('App\Models\User', 'second_user_id');

    }
    
}


