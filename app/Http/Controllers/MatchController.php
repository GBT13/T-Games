<?php

namespace App\Http\Controllers;

use App\Match;
use App\Profile;
use App\User;
use Auth;
use Illuminate\Http\Request;

class MatchController extends Controller {
//    public function getAllPendingMatches($id) {
//        $matches1 = Profile::findOrFail($id)->possibleMatchesMatcher()->get();
//        $matches2 = Profile::findOrFail($id)->possibleMatchesMatchee()->get();
//
//        return $allMatches = $matches1->push($matches2);
//    }
//
//    public function getAllProfilesFromMatch($id) {
//        $profile1 = Match::findOrFail($id)->matcherProfile()->get();
//        $profile2 = Match::findOrFail($id)->matcheeProfile()->get();
//
//        return $allProfiles = $profile1->push($profile2);
//    }

    public function getAllPendingMatches($id) {
        return Profile::findOrFail($id)->possibleMatches();
    }

    public function getAllMutuallyAcceptedMatches($id) {
        return Profile::findOrFail($id)->mutuallyAcceptedMatches();
    }

    public function findMatches($id) {
//        $ownProfile = Auth::user()->profile();
        $ownProfile = Profile::findOrFail($id);
        $otherProfiles = Profile::whereKeyNot($id)->get();
        $foundMatches = ['matches' => []];

        foreach ($otherProfiles as $profile) {
            $matchScore = count(($profile->games()->get()->intersect($ownProfile->games()->get())));

            if ($matchScore > 1) {
                array_add($profile, 'user', $profile->user()->get());
                array_add($profile, 'matched_games', $profile->games()->get()->intersect($ownProfile->games()->get()));
                array_push($foundMatches['matches'], $profile);

            }

        }

        return $foundMatches;
    }


}
