<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'image_location',
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
    ];

    public function country(){
        return $this->belongsTo('App\Country');
    }

    public function user(){
        return $this->hasOne('App\User');
    }

    public function games(){
        return $this->belongsToMany('App\Game');
    }

}
