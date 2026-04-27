<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    /* public function test_example(): void
     {
         $response = $this->get('/');

         $response->assertStatus(200);
     }*/


    public function user_can_register()
    {
        $this->post('/register', [
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@user.com',
            'password' => 'Password123',
            'password_confirmation' => 'Password123'
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@user.com',
            'username' => 'testuser'
        ]);
    }
}
