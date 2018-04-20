<?php

namespace Tests\Feature;

use App\User;
use JWTAuth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase {
    public function testLogin() {
        $response = $this->post('/api/auth/login', ['email' => 'test@test.com', 'password' => env('TESTPASS')]);

        $response->assertStatus(200);
    }

    public function testProfile() {
        $token = JWTAuth::fromUser(User::find(1));

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])->get('api/user/1/profile/withgames');

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
