<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterFormRequest;
use App\Profile;
use App\User;
use Auth;
use Hash;
use Illuminate\Http\Request;
use JWTAuth;

class AuthController extends Controller {
    public function register(RegisterFormRequest $request) {

        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'birthdate' => $request->birthdate,
            'gender' => $request->gender,
        ]);

        $user->profile()->create();

        return $user;


//        $user = new User;
//        $user->email = $request->email;
//        $user->name = $request->name;
//        $user->password = bcrypt($request->password);
//        $user->save();
//
//        return response([
//            'status' => 'success',
//            'data' => $user
//        ], 200);
    }

    public function login(Request $request) {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response([
                'status' => 'error',
                'error' => 'invalid.credentials',
                'msg' => 'Invalid Credentials.'
            ], 400);
        }

        return response([
            'status' => 'success'
        ])
            ->header('Authorization', $token);
    }

    public function user(Request $request) {
        $user = User::with('profile')->findOrFail(Auth::user()->id);

        return response([
            'status' => 'success',
            'data' => $user,
        ]);
    }

    public function refresh() {
        return response([
            'status' => 'success'
        ]);
    }

    public function logout() {
        JWTAuth::invalidate();

        return response([
            'status' => 'success',
            'msg' => 'Logged out Successfully.'
        ], 200);
    }

    public function checkEmailExists(Request $request) {
        if (User::where('email', $request->email)->exists()) {
            return response('Duplicate!', 409);
        } else {
            return response('Unique', 200);
        }
    }


}
