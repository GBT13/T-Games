<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    protected $fillable = [
        'matched1', 'matched2', 'accepted_1', 'accepted_2', 'rejected'
    ];

    public function matcherProfile(){
        return $this->belongsTo('App\Profile', 'matched_1');
    }

    public function matcheeProfile(){
        return $this->belongsTo('App\Profile', 'matched_2');
    }
}
