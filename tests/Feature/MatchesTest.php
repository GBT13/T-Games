<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MatchesTest extends TestCase {

    public function testMatches() {
        $response = $this->withHeaders(['Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImlzcyI6Imh0dHA6Ly90aW5kZXJnYW1lcy50ZXN0L2FwaS9hdXRoL2xvZ2luIiwiaWF0IjoxNTI0MDQxODUxLCJleHAiOjE1MjQwNDU0NTEsIm5iZiI6MTUyNDA0MTg1MSwianRpIjoiVTNNQzFSa2RpRjl0d3ozSyJ9.f2Fn82RWHC8O9NZZ05apOM7AULacgY_Ji_G45RXI_HY'])->get('api/matches/find/1');

        $response->assertJsonStructure([
            'matches' => ['*' => ['id', 'imageLocation',
                'matched_games' => ['*' => ['id', 'appid', 'name']],
                'user' => ['id', 'firstname', 'lastname']]]]);
    }

    public function testMutualMatches() {
        $response = $this->withHeaders(['Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImlzcyI6Imh0dHA6Ly90aW5kZXJnYW1lcy50ZXN0L2FwaS9hdXRoL2xvZ2luIiwiaWF0IjoxNTI0MDQxODUxLCJleHAiOjE1MjQwNDU0NTEsIm5iZiI6MTUyNDA0MTg1MSwianRpIjoiVTNNQzFSa2RpRjl0d3ozSyJ9.f2Fn82RWHC8O9NZZ05apOM7AULacgY_Ji_G45RXI_HY'])->get('api/matches/mutual');

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
