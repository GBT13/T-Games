<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Http\Request;

class UserController extends Controller {
    public function updateAccountSettings(Request $request) {
        $user = Auth::user();
        if (($request['password'])) {
            $request['password'] = bcrypt($request['password']);
            $user->update($request->all());
            return $user;
        } elseif (!($request['password'])) {
            Auth::user()->update($request->except('password'));
            return $user;
        } else {
            return response([
                'status' => 'error',
                'error' => 'processing.error',
                'msg' => 'Internal server error occurred'
            ], 500);
        }

    }
}
