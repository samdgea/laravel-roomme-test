<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Support\Facades\Hash;

class UserManagementTest extends TestCase
{
    /**
     * Test akses rute user management tanpa authentikasi
     *
     * @return void
     */
    public function testAccessListRegisteredUserWithoutLogin()
    {

        $response = $this->getJson('/user',  ['Content-Type' => 'application/json']);

        $response->assertStatus(401)
                 ->assertJson(['message' => 'Unauthenticated.']);
    }

    /**
     * Test akses rute user management dengan authentikasi, tetapi tidak memiliki akses ke modul tersebut
     *
     * @return void
     */
    public function testAccessListRegisteredUserWithAuthenticatedUserNonAccess()
    {
        $notAuthenticatedUser = \App\Models\User::where('email', 'no-access-account@abdilah.id')->first();

        $response = $this->actingAs($notAuthenticatedUser, 'api')
                         ->getJson('/user',  ['Content-Type' => 'application/json']);

        $response->assertStatus(403)
                 ->assertJson(['success' => false, 'desc' => 'User does not have the right permissions.']);
    }

    /**
     * Test akses rute user management dengan authentikasi dan memiliki akses ke modul tersebut
     *
     * @return void
     */
    public function testAccessListRegisteredUserWithAuthenticatedUserWithAccess()
    {
        $authenticatedUser = \App\Models\User::where('email', 'hello@abdilah.id')->first();

        $response = $this->actingAs($authenticatedUser, 'api')
                         ->getJson('/user',  ['Content-Type' => 'application/json']);

        $response->assertStatus(200)
                 ->assertJson(['success' => true]);
    }

    /**
     * Test buat user baru
     *
     * @return void
     */
    public function testCreateNewUser()
    {
        $authenticatedUser = \App\Models\User::where('email', 'hello@abdilah.id')->first();

        $user = \App\Models\User::where('email', 'test@abdilah.id')->first();

        if ($user) $user->delete();

        $response = $this->actingAs($authenticatedUser, 'api')
                         ->postJson('/user', [
                             'first_name' => 'Test', 
                             'last_name' => 'User', 
                             'email' => 'test@abdilah.id', 
                             'password' => Hash::make('password'),
                             'is_active' => 0,
                         ],  ['Content-Type' => 'application/json']);

        $response->assertStatus(201)
                 ->assertJson(['success' => true]);
    }

    /**
     * Test edit user baru
     * 
     * @return void
     */
    public function testModifyNewUser()
    {
        $authenticatedUser = \App\Models\User::where('email', 'hello@abdilah.id')->first();

        $user = \App\Models\User::where('email', 'test@abdilah.id')->first();

        $response = $this->actingAs($authenticatedUser, 'api')
                         ->putJson("/user/{$user->id}", [
                            'first_name' => 'Test', 
                            'last_name' => 'User Modify', 
                        ],  ['Content-Type' => 'application/json']);

        $response->assertStatus(200)
                        ->assertJson(['data' => ['last_name' => 'User Modify']]);
    }

    /**
     * Test delete user baru
     * 
     * @return void
     */
    public function testDeleteNewUser()
    {
        $authenticatedUser = \App\Models\User::where('email', 'hello@abdilah.id')->first();

        $user = \App\Models\User::where('email', 'test@abdilah.id')->first();

        if (empty($user)) {
            $user = \App\Models\User::create([
                'first_name' => 'Test', 
                'last_name' => 'User', 
                'email' => 'test@abdilah.id', 
                'password' => Hash::make('password'),
                'is_active' => 0,
            ]);
        }

        $response = $this->actingAs($authenticatedUser, 'api')
                         ->deleteJson("/user/{$user->id}", [],  ['Content-Type' => 'application/json']);
                        
        $response->assertStatus(410)
                        ->assertJson(['success' => true]);
    }
}
