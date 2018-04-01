<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = ['appid', 'name', 'developer', 'publisher'];

    public function profiles(){
        return $this->belongsToMany('App\Profile');
    }
}
