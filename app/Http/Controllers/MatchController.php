<?php

namespace App\Http\Controllers;

use App\Match;
use App\Profile;
use App\User;
use Auth;
use Illuminate\Http\Request;

class MatchController extends Controller {

    public function getAllPendingMatches($id) {
        return Profile::findOrFail($id)->possibleMatches()->get();
    }

//    public function getAllMutuallyAcceptedMatches($id) {
//        return Profile::findOrFail($id)->mutuallyAcceptedMatches();
//    }

    public function rejectMatch($partnerId) {
        $ownProfile = Auth::user()->profile()->first();
        return Match::whereProfileId($ownProfile->id)->wherePartnerProfileId($partnerId)->update(['rejected' => true]);
    }

    public function acceptMatch($partnerId) {
        $ownProfile = Auth::user()->profile()->first();
        $ownMatch = Match::whereProfileId($ownProfile->id)->wherePartnerProfileId($partnerId)->update(['accepted' => true]);

        if (Match::whereProfileId($partnerId)->wherePartnerProfileId($ownProfile->id)->first()->accepted == 1) {
            return response([
                'status' => 'success',
                'MUTUAL_MATCH' => true
            ]);
        } else {
            return response([
                'status' => 'success',
                'MUTUAL_MATCH' => false
            ]);
        }
    }

    public function findMatches($id) {
//        $ownProfile = Auth::user()->profile();
        $ownProfile = Profile::findOrFail($id);
        $otherProfiles = Profile::whereKeyNot($id)->get();
        $foundMatches = ['matches' => []];

//        Loop through all possible partnerProfiles
        foreach ($otherProfiles as $partnerProfile) {
            $matchScore = count(($partnerProfile->games()->get()->intersect($ownProfile->games()->get())));

//            If this matchup has more than 1 game in common, continue
            if ($matchScore > 1) {
//                Check to see if this match pair already exists
                if ($ownMatch = Match::whereProfileId($ownProfile->id)->wherePartnerProfileId($partnerProfile->id)->first()) {
                    $partnerMatch = Match::whereProfileId($partnerProfile->id)->wherePartnerProfileId($ownProfile->id)->first();

                    // If neither user has rejected the match, and we haven't accepted it yet, add the partnerProfile to the foundMatches
                    if ($ownMatch->rejected !== 1 && $partnerMatch->rejected !== 1 && $ownMatch->accepted !== 1) {
                        $foundMatches = $this->addMatchToArray($foundMatches, $ownProfile, $partnerProfile);
                    }
//                    If this user matchup doesn't exist yet, add the partnerProfile to the foundMatches, and add the match pair to the database
                } else {
                    $foundMatches = $this->addMatchToArray($foundMatches, $ownProfile, $partnerProfile);
                    Match::create(['profile_id' => $ownProfile->id, 'partner_profile_id' => $partnerProfile->id]);
                    Match::create(['profile_id' => $partnerProfile->id, 'partner_profile_id' => $ownProfile->id]);
                }
            }
        }
        return $foundMatches;
    }

    private function addMatchToArray($matchArray, $ownProfile, $partnerProfile) {
        array_add($partnerProfile, 'user', $partnerProfile->user()->get());
        array_add($partnerProfile, 'matched_games', $partnerProfile->games()->get()->intersect($ownProfile->games()->get()));
        array_push($matchArray['matches'], $partnerProfile);

        return $matchArray;
    }
}
