<?php

namespace App\Http\Controllers;

use App\Match;
use App\Profile;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Response;
use Storage;

class ProfileController extends Controller {
    public function getProfileByUser($id) {
        return User::findOrFail($id)->profile()->first();
    }

    public function getProfileAndGamesByUser($id) {
        return User::findOrFail($id)->profile()->with('games')->with('user')->first();
    }

    /**
     * Used to fetch profiles from users you match with
     * @param $id
     * @return mixed
     */
    public function getProfileAndGamesByMutualMatch($id) {
        $matchProfile = User::findOrFail($id)->profile()->with('games')->with('user')->first();
        $ownProfile = Auth::user()->profile()->first();
        $ownMatch = Match::whereProfileId($ownProfile->id)->wherePartnerProfileId($matchProfile->id)->first();
        $partnerMatch = Match::whereProfileId($matchProfile->id)->wherePartnerProfileId($ownProfile->id)->first();

        if ($ownMatch && $partnerMatch) {
            if ($ownMatch['accepted'] === 1 && $partnerMatch['accepted'] === 1) {
                if ($ownMatch['rejected'] != 1 && $partnerMatch['rejected'] != 1) {
                    return $matchProfile;
                } else {
                    return response([
                        'status' => 'error',
                        'error' => 'rejected.error',
                        'msg' => 'Match rejected'
                    ], 500);
                }
            } else {
                return response([
                    'status' => 'error',
                    'error' => 'notaccepted.error',
                    'msg' => 'Match not mutually accepted'
                ], 500);
            }
        } else {
            return response([
                'status' => 'error',
                'error' => 'notfound.error',
                'msg' => 'No match found'
            ], 500);
        }
    }

    public function updateProfile(Request $request) {
        $profile = $this->getProfileByUser($request['userId']);

        if ($profile->update($request->except('profileGameList'))) {
            $profile->games()->detach();
            $profile->games()->attach(array_unique($request->get('profileGameList')));

            if ($fileData = $request['profilePicture']) {
                $fileName = 'profile_picture_' . $profile->id . '_' . time() . '.png';
                @list($type, $fileData) = explode(';', $fileData);
                @list(, $fileData) = explode(',', $fileData);
                Storage::disk('profilePictures')->put($fileName, base64_decode($fileData));

                $profile->update(['imageLocation' => '/images/profiles/' . $fileName]);
            }


            return $profile;
        } else return response([
            'status' => 'error',
            'error' => 'processing.error',
            'msg' => 'Internal server error occurred'
        ], 500);

    }

}
