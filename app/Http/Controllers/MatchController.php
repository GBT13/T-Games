<?php

namespace App\Http\Controllers;

use App\Match;
use App\Profile;
use App\User;
use Auth;
use Illuminate\Http\Request;

class MatchController extends Controller {
    public function getAllPendingMatches($id) {
        $matches1 = Profile::findOrFail($id)->possibleMatchesMatcher()->get();
        $matches2 = Profile::findOrFail($id)->possibleMatchesMatchee()->get();

        return $allMatches = $matches1->push($matches2);
    }

    public function getAllProfilesFromMatch($id) {
        $profile1 = Match::findOrFail($id)->matcherProfile()->get();
        $profile2 = Match::findOrFail($id)->matcheeProfile()->get();

        return $allProfiles = $profile1->push($profile2);
    }

    public function findMatches($id) {
//        $ownProfile = Auth::user()->profile();
        $ownProfile = Profile::findOrFail($id);
        $otherProfiles = Profile::whereKeyNot($id)->get();

//        return $otherProfiles->get();

        $foundMatches = [];

//        return $ownProfile->games()->get();

        foreach ($otherProfiles as $profile) {
            $matchScore = 0;
            foreach ($profile->games()->get() as $game) {
                foreach ($ownProfile->games()->get() as $ownGame) {
                    if ($game->id === $ownGame->id) {
                        $matchScore++;
                        if ($matchScore > 1) {
                            array_push($foundMatches, $profile);
                        }

                    }
                }
            }
        }

        return $foundMatches;
    }


}
