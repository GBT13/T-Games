<?php

namespace App\Http\Controllers;

use App\Game;
use App\Profile;
use App\User;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function getAllGamesNameOnly(){
        return Game::all(['id', 'name']);
    }

    public function getAllGames(){
        return Game::all();
    }

    public function getGamesLike(Request $request){
        return Game::where('name', 'LIKE', '%' . $request->query('name'). '%')->get();
    }

    public function getGamesByProfile($id){
        return User::findOrFail($id)->profile()->first()->games()->get();
    }
}
