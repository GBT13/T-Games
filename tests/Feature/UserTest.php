<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase {
    public function testLogin() {
        $response = $this->post('/api/auth/login', ['email' => 'test@test.com', 'password' => 'TestTestTest']);

        $response->assertStatus(200);
    }

    public function testProfile() {
        $response = $this->withHeaders(['Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImlzcyI6Imh0dHA6Ly90aW5kZXJnYW1lcy50ZXN0L2FwaS9hdXRoL2xvZ2luIiwiaWF0IjoxNTI0MDQxODUxLCJleHAiOjE1MjQwNDU0NTEsIm5iZiI6MTUyNDA0MTg1MSwianRpIjoiVTNNQzFSa2RpRjl0d3ozSyJ9.f2Fn82RWHC8O9NZZ05apOM7AULacgY_Ji_G45RXI_HY'])->get('api/user/1/profile/withgames');

        $response->assertJson(['id' => 1]);
    }

    public function testProfileAuth() {
        $response = $this->get('api/user/1/profile/withgames');
        $response->assertStatus(400);
    }

    public function testEditAuth() {
        $response = $this->patch('api/user/updateaccount');
        $response->assertStatus(400);

        $response = $this->patch('api/user/updateprofile');
        $response->assertStatus(400);
    }
}
