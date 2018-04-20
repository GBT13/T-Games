<?php

namespace Tests\Feature;

use App\User;
use JWTAuth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MatchesTest extends TestCase {

    public function testMatches() {
        $token = JWTAuth::fromUser(User::find(1));
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])->get('api/matches/find/1');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'matches' => ['*' => ['id', 'imageLocation',
                'matched_games' => ['*' => ['id', 'appid', 'name']],
                'user' => ['id', 'firstname', 'lastname']]]]);
    }

    public function testMutualMatches() {
        $token = JWTAuth::fromUser(User::find(1));
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])->get('api/matches/mutual');
        $response->assertStatus(200);

        $response->assertJsonStructure([
            '*' => ['id', 'imageLocation',
                'user' => ['id', 'firstname', 'lastname']]
        ]);


    }

    public function testMatchesAuth() {
        $response = $this->get('api/matches/find/1');
        $response->assertStatus(400);
    }

    public function testMatchesEditAuth() {
        $response = $this->patch('api/matches/1/accept');
        $response->assertStatus(400);

        $response = $this->patch('api/matches/1/reject');
        $response->assertStatus(400);

        $response = $this->get('api/matches/mutual');
        $response->assertStatus(400);
    }

}
