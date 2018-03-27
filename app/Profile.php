<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'image_location',
        'bioText',
        'country_id',
        'steamname',
        'playstationname',
        'xboxname',
        'discordname',
        'epicname',
        'nintendoname',
        'eaname',
        'uplayname',
        'blizzardname'
    ];

    public function country(){
        return $this->belongsTo('App\Country');
    }

    public function user(){
        return $this->hasOne('App\User');
    }

}
