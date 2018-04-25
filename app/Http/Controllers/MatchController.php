<?php

namespace App\Http\Controllers;

use App\Match;
use App\Profile;
use App\User;
use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class MatchController extends Controller {

    public function rejectMatch($partnerId) {
        $ownProfile = Auth::user()->profile()->first();
        return $this->getPairedMatch($ownProfile->id, $partnerId)->update(['rejected' => true]);
    }

    public function acceptMatch($partnerId) {
        $ownProfile = Auth::user()->profile()->first();
        $ownMatch = $this->getPairedMatch($ownProfile->id, $partnerId)->update(['accepted' => true]);

        if ($this->getPairedMatch($partnerId, $ownProfile->id)->first()->accepted == 1) {
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

    public function findMatches() {
        $ownProfile = Auth::user()->profile()->first();
        $otherProfiles = Profile::whereKeyNot($ownProfile->id)->get(['id', 'imageLocation', 'bio', 'user_id']);
        $foundMatches = ['matches' => []];

//        Loop through all possible partnerProfiles
        foreach ($otherProfiles as $partnerProfile) {
            $matchScore = count(($partnerProfile->games()->get()->intersect($ownProfile->games()->get())));

//            If this matchup has more than 1 game in common, continue
            if ($matchScore > 1) {
//                Check to see if this match pair already exists
                if ($ownMatch = $this->getPairedMatch($ownProfile->id, $partnerProfile->id)->first()) {
                    $partnerMatch = $this->getPairedMatch($partnerProfile->id, $ownProfile->id)->first();

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

    public function getAllMutualMatches() {
        $mutualMatchProfiles = [];
        $acceptedMatches = Match::whereProfileId(Auth::user()->profile()->first()->id)->whereAccepted(1)->whereRejected(0)->get();

        foreach ($acceptedMatches as $acceptedMatch) {
            if ($this->getPairedMatch($acceptedMatch['partner_profile_id'], $acceptedMatch['profile_id'])->whereAccepted(1)->whereRejected(0)->first()) {
                array_push($mutualMatchProfiles, (Profile::whereId($acceptedMatch['partner_profile_id'])->with(['user', 'games'])->first()));
            }
        }

        return $mutualMatchProfiles;
    }

    private function addMatchToArray($matchArray, $ownProfile, $partnerProfile) {
        array_add($partnerProfile, 'user', $partnerProfile->user()->get());
        array_add($partnerProfile, 'matched_games', $partnerProfile->games()->get()->intersect($ownProfile->games()->get()));
        array_push($matchArray['matches'], $partnerProfile);

        return $matchArray;
    }

    /**
     * Used to find matches in a pair based on profile_id and partner_profile_id
     * @param $profileId
     * @param $partnerProfileId
     * @return Match
     */
    private function getPairedMatch($profileId, $partnerProfileId){
        return Match::whereProfileId($profileId)->wherePartnerProfileId($partnerProfileId);
    }
}
