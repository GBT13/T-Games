<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MatchesTest extends TestCase {

    public function testMatches() {
        $response = $this->withHeaders(['Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImlzcyI6Imh0dHA6Ly90aW5kZXJnYW1lcy50ZXN0L2FwaS9hdXRoL3JlZnJlc2giLCJpYXQiOjE1MjQwNDQwODMsImV4cCI6MTUyNDA3MjQzNSwibmJmIjoxNTI0MDY4ODM1LCJqdGkiOiJGbFdGT0x2QkhWeXVJaDNqIn0.rrm63OEPTr-FviHxgkmERXrHYQdVPJUk7-BxgboC2gs'])->get('api/matches/find/1');

        $response->assertJsonStructure([
            'matches' => ['*' => ['id', 'imageLocation',
                'matched_games' => ['*' => ['id', 'appid', 'name']],
                'user' => ['id', 'firstname', 'lastname']]]]);
    }

    public function testMutualMatches() {
        $response = $this->withHeaders(['Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImlzcyI6Imh0dHA6Ly90aW5kZXJnYW1lcy50ZXN0L2FwaS9hdXRoL3JlZnJlc2giLCJpYXQiOjE1MjQwNDQwODMsImV4cCI6MTUyNDA3MjQzNSwibmJmIjoxNTI0MDY4ODM1LCJqdGkiOiJGbFdGT0x2QkhWeXVJaDNqIn0.rrm63OEPTr-FviHxgkmERXrHYQdVPJUk7-BxgboC2gs'])->get('api/matches/mutual');

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
