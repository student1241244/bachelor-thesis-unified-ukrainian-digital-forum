<?php

namespace Unit\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ValidLoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function testValidLogin()
    {
        // Arrange: create a user
        $data = [
            'role_id' => 2,
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'username' => 'test',
            'is_admin' => 0,
            'ban_to' => null
        ];
        User::create($data);

        $response = $this->post('/login', [
            'loginusername' => 'test',
            'loginpassword' => 'password',
        ]);

        // Assert: check if redirected to home/dashboard
        $response->assertStatus(200); // Check for a 200 OK status
        $response->assertViewIs('qa-home');
    }
}
