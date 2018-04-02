<?php

namespace App\Http\Controllers;

use App\Profile;
use App\User;
use Illuminate\Http\Request;
use Response;
use Storage;

class ProfileController extends Controller {
    public function getProfileByUser($id) {
        return User::findOrFail($id)->profile()->first();
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

                $profile->update(['imageLocation' => 'images/profiles/' . $fileName]);
            }


            return $profile;
        } else return response([
            'status' => 'error',
            'error' => 'processing.error',
            'msg' => 'Internal server error occurred'
        ], 500);

    }

}
