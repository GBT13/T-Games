<?php

namespace App\Http\Controllers;

use App\Profile;
use App\User;
use Illuminate\Http\Request;
use Response;

class ProfileController extends Controller {
    public function getProfileByUser($id) {
        return User::findOrFail($id)->profile()->first();
    }

    public function updateProfile(Request $request) {
        $profile = $this->getProfileByUser($request['userId']);

        if ($profile->update($request->all())){
            return $profile;
        }

        else return response([
            'status' => 'error',
            'error' => 'processing.error',
            'msg' => 'Internal server error occurred'
        ], 500);

    }

}
