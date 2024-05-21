<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function testAuth()
    {
        $this->seed(UserSeeder::class);

        $success = Auth::attempt([
            "email" => "bram@localhost",
            "password" => "rahasia"
        ], true);
        self::assertTrue($success);

        $user = Auth::user();
        self::assertNotNull($user);
        self::assertEquals("bram@localhost", $user->email);
    }

    public function testGuest()
    {
        $user = Auth::user();
        self::assertNull($user);
    }

    public function testLogin()
    {
        $this->seed(UserSeeder::class);

        $this->get("/users/login?email=bram@localhost&password=rahasia")
            ->assertRedirect("/users/login");
        
        $this->get("/users/login?email=salah@localhost&password=rahasia")
            ->assertSeeText("Wrong credentials");
    }

    public function testCurrent()
    {
        $this->seed(UserSeeder::class);

        $this->get("/users/current")
            ->assertStatus(302)
            ->assertRedirect("/login");

        $user = User::where('email', 'bram@localhost')->firstOrFail();
        $this->actingAs($user);
        $this->get("/users/current")
            ->assertSeeText("Hello Bramasta Albatio");
    }

    public function testUserProvider()
    {
        $this->seed(UserSeeder::class);

        $this->get("/api/users/current", [
            "Accept" => "application/json"
        ])
            ->assertStatus(401);

        $this->get("/api/users/current", [
            "Accept" => "application/json",
            "API-Key" => "secret"
        ])
            ->assertSeeText("Hello Bramasta Albatio");
    }

    public function testCurrentProvider()
    {
        $this->seed(UserSeeder::class);

        $this->get("/api/users/current", [
            "Accept" => "application/json"
        ])
            ->assertStatus(401);

        $this->get("/simple-api/users/current", [
            "Accept" => "application/json",
            "API-Key" => "secret"
        ])
            ->assertSeeText("bramasta");
    }
}
