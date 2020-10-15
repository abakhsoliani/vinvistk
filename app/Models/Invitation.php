<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_from_id',
        'league_id',
        'user_to_id',
        'status',
    ];

    public function league()
    {
        return $this->belongsTo('App\Models\League');
    }
}
