<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use function Laravel\Prompts\password;


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


    public function test_user_can_register()
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

    public function test_user_can_login()
    {
        $user = User::factory()->create([
            'password' => 'Password1234'
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'Password1234'
        ]);

        $this->assertAuthenticated();
    }
}
