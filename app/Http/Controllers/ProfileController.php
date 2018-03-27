<?php

namespace App\Http\Controllers;

use App\Profile;
use App\User;
use Illuminate\Http\Request;
use Response;

class ProfileController extends Controller
{
    public function getProfileByUser($id){
        return User::findOrFail($id)->profile()->first();
    }

}
