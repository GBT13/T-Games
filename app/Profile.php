<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model {
    protected $fillable = [
        'imageLocation',
        'bio',
        'country_id',
        'steamid',
        'psnName',
        'xboxGamertag',
        'originName',
        'uplayName',
        'battletag',
        'discord',
        'epicName',
        'nintendoNetworkId',
        'user_id',
    ];

    public function getImageLocation($value){
        if(!$value){
            return '/images/profile_placeholder.bmp';
        }
        else {
            return $value;
        }
    }

    public function country() {
        return $this->belongsTo('App\Country');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function games() {
        return $this->belongsToMany('App\Game');
    }

    public function possibleMatches() {
        return $this->hasmany('App\Match')->whereRejected(0);
    }

}
