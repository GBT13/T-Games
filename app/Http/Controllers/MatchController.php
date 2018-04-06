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

    public function rejectMatch($partnerId){
        $ownProfile = Auth::user()->profile()->first();
//        return Match::whereProfileId($ownProfile->id)->wherePartnerProfileId($partnerId)->update(['rejected' => true]);
        return 1;
    }

    public function findMatches($id) {
//        $ownProfile = Auth::user()->profile();
        $ownProfile = Profile::findOrFail($id);
        $otherProfiles = Profile::whereKeyNot($id)->get();
        $foundMatches = ['matches' => []];

        foreach ($otherProfiles as $partnerProfile) {
            $matchScore = count(($partnerProfile->games()->get()->intersect($ownProfile->games()->get())));

            if ($matchScore > 1) {
                array_add($partnerProfile, 'user', $partnerProfile->user()->get());
                array_add($partnerProfile, 'matched_games', $partnerProfile->games()->get()->intersect($ownProfile->games()->get()));
                array_push($foundMatches['matches'], $partnerProfile);

//                Fetch all matches for the profiles of the current profile iteration
                $existingOwnMatches = Match::whereProfileId($ownProfile->id)->get();
                $existingPartnerMatches = Match::whereProfileId($partnerProfile->id)->get();


//                Check whether there are any matches in the database
                if ($existingOwnMatches && $existingPartnerMatches) {
                    $existingMatchAmount = 0;

//                    For each match check if there is an existing paired match already
                    foreach ($existingOwnMatches as $existingOwnMatch) {
                        foreach ($existingPartnerMatches as $existingPartnerMatch) {
                            if ($existingOwnMatch->partner_match_id === $existingPartnerMatch->id || $existingOwnMatch->id === $existingPartnerMatch->partner_match_id) {
                                $existingMatchAmount++;

//                                If one of the two people has rejected the match already splice it from the possible profiles that are returned so it won't show up again for either user
                                if ($existingOwnMatch->rejected === 1 || $existingPartnerMatch->rejected === 1) {
                                    array_splice($foundMatches['matches'], (array_search(['id' => $existingPartnerMatch->profile_id], $foundMatches['matches'])), 1);
                                }
                            }

                        }
                    }

//                    If no match pair has been found for the current profile iteration create them in the database
                    if ($existingMatchAmount < 1) {
                        $ownMatch = Match::create(['profile_id' => $ownProfile->id, 'partner_profile_id' => $partnerProfile->id]);
                        $partnerMatch = Match::create(['profile_id' => $partnerProfile->id, 'partner_match_id' => $ownMatch->id, 'partner_profile_id' => $ownProfile->id]);
                        $ownMatch->update(['partner_match_id' => $partnerMatch->id]);
                    }

//                    If there are no matches in the database whatsoever for the current profile iteration create them immediately
                } else {
                    $ownMatch = Match::create(['profile_id' => $ownProfile->id, 'partner_profile_id' => $partnerProfile->id]);
                    $partnerMatch = Match::create(['profile_id' => $partnerProfile->id, 'partner_match_id' => $ownMatch->id, 'partner_profile_id' => $ownProfile->id]);
                    $ownMatch->update(['partner_match_id' => $partnerMatch->id]);
                }

            }

        }

        return $foundMatches;
    }

    //TODO: Rework the matches table to add partner_profile_id, and make sure it's added when finding matches. With this new table layout it's easier and more performance friendly to find mutual matches


}
