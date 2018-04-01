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
        'user_id'
    ];

    public function country(){
        return $this->belongsTo('App\Country');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function games(){
        return $this->belongsToMany('App\Game');
    }

    public function possibleMatches(){
        return $this->hasmany('App\Match')->whereRejected(0);
    }

    public function mutuallyAcceptedMatches(){
        $ownAccepted = $this->hasMany('App\Match')->whereAccepted(1);
        $partnerAccepted = [];
        foreach ($ownAccepted as $acceptedMatch) {
            if ($acceptedMatch->matchPartner()->accepted === 1){
                $partnerAccepted->push($acceptedMatch);
            }
        }
    }

}
