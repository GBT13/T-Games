<?php

namespace App\Http\Controllers;

use App\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function getAllGamesNameOnly(){
        return Game::all(['id', 'name']);
    }

    public function getAllGames(){
        return Game::all();
    }
}
