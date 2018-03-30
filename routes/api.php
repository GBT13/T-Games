<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('auth/register', 'AuthController@register');
Route::post('auth/login', 'AuthController@login');
//Route::get('auth/user/emailduplicate', 'AuthController@checkEmailExists');
Route::get('games/names', 'GameController@getGamesLike');


Route::group(['middleware' => 'jwt.auth'], function () {
//    Login Routes
    Route::get('auth/user', 'AuthController@user');
    Route::post('auth/logout', 'AuthController@logout');

//    Game Routes
    Route::get('games/all/names', 'GameController@getAllGamesNameOnly');
    Route::get('games/all', 'GameController@getAllGames');

//    Account management Routes
    Route::get('user/{id}/profile', 'ProfileController@getProfileByUser');
    Route::patch('user/updateprofile', 'ProfileController@updateProfile');
    Route::patch('user/updateaccount', 'UserController@updateAccountSettings');

});

Route::group(['middleware' => 'jwt.refresh'], function () {
    Route::get('auth/refresh', 'AuthController@refresh');
});

