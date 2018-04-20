<?php

namespace Tests\Feature;

use App\User;
use JWTAuth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GameTest extends TestCase {
    public function testAllGames() {
        $token = JWTAuth::fromUser(User::find(1));
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('api/games/all');
        $response->assertJsonStructure([
            '*' => [
                'id',
                'appid',
                'name',
                'developer',
                'publisher'
            ]
        ]);
    }

    public function testAllGamesNameOnly() {
        $token = JWTAuth::fromUser(User::find(1));
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('api/games/all/names');
        $response->assertJsonStructure([
            '*' => [
                'id',
                'name'
            ]
        ]);
    }

    public function testGameAuth() {
        $response = $this->get('api/games/all');
        $response->assertStatus(400);

        $response = $this->get('api/games/all/names');
        $response->assertStatus(400);

        $response = $this->get('api/games/names');
        $response->assertStatus(400);
    }


}
