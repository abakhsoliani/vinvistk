<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sport extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_en',
        'image',
        'min_change',
        'max_change',
        'premial_scale',
        'premial_score',
        'max_point_difference',
        'starting_point',
        'goal_name_en',
        'goal_name_ge',
        'has_draw',//0no1yes
        'draw_scale'
    ];


    

    public function leagues(){
        return $this->hasMany('App\Models\League');
    }
}
