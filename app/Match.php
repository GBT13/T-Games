<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    protected $fillable = [
        'profile_id', 'partner_profile_id', 'accepted', 'rejected'
    ];

    public function profile(){
        return $this->belongsTo('App\Profile');
    }

    public function matchPartner($id){
        return Match::whereId($id);
    }

}
