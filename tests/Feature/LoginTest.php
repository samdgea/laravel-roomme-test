<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * @test
     * @testdoc Login API dengan Detail kredensial yang tidak valid
     */
    public function testLoginWithInvalidDetails()
    {
        $response = $this->postJson('login', ['email' => 'wrongcredential@abdilah.id', 'password' => 'wrong_password'], ['Content-Type' => 'application/json']);

        $response->assertStatus(404)
                 ->assertJson(['success' => false, 'desc' => 'Invalid email, password combination, or inactive account']);
    }

    /**
     * @test
     * @testdoc Login API dengan Detail kredensial yang valid
     */
    public function testLoginWithValidDetails()
    {
        $response = $this->postJson('login', ['email' => 'hello@abdilah.id', 'password' => 'password'], ['Content-Type' => 'application/json']);

        $response->assertStatus(200);
    }

    /**
     * @test
     * @testdoc Login API dengan Detail kredensial yang valid tetapi status akun tidak aktif
     */
    public function testLoginWithDisabledAccountDetails()
    {
        $response = $this->postJson('login', ['email' => 'disabled-account@abdilah.id', 'password' => 'password'], ['Content-Type' => 'application/json']);

        $response->assertStatus(404);
    }
}
