<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BuildingTest extends TestCase
{
    /**
     * Access List of Buildings without login
     *
     * @return void
     */
    public function testAccessListOfBuildingWithoutLogin()
    {
        $response = $this->getJson('/building',  ['Content-Type' => 'application/json']);

        $response->assertStatus(401)
                 ->assertJson(['message' => 'Unauthenticated.']);
    }

    /**
     * Test akses rute building management dengan authentikasi, tetapi tidak memiliki akses ke modul tersebut
     *
     * @return void
     */
    public function testAccessListOfBuildingWithAuthenticatedUserNonAccess()
    {
        $notAuthenticatedUser = \App\Models\User::where('email', 'no-access-account@abdilah.id')->first();

        $response = $this->actingAs($notAuthenticatedUser, 'api')
                         ->getJson('/building',  ['Content-Type' => 'application/json']);

        $response->assertStatus(403)
                 ->assertJson(['success' => false, 'desc' => 'User does not have the right permissions.']);
    }

    /**
     * Test akses rute building management dengan authentikasi dan memiliki akses ke modul tersebut
     *
     * @return void
     */
    public function testAccessListOfBuildingWithAuthenticatedUserWithAccess()
    {
        $authenticatedUser = \App\Models\User::where('email', 'hello@abdilah.id')->first();

        $response = $this->actingAs($authenticatedUser, 'api')
                         ->getJson('/building',  ['Content-Type' => 'application/json']);

        $response->assertStatus(200)
                 ->assertJson(['success' => true]);
    }

    /**
     * Test buat building baru
     *
     * @return void
     */
    public function testCreateNewBuilding()
    {
        $authenticatedUser = \App\Models\User::where('email', 'hello@abdilah.id')->first();

        $building = \App\Models\Building\Header::where('building_title', 'Kos Mamah Lela')->first();

        if ($building) $building->delete();

        $response = $this->actingAs($authenticatedUser, 'api')
                         ->postJson('/building', [
                             'building_title' => 'Kos Mamah Lela', 
                             'building_address' => 'Jalan Pembina III No.16 RT.05 RW.06 Matraman Jakarta Timur', 
                             'building_desc' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
                             'building_lat_coordinate' => '-6.2061278',
                             'building_long_coordinate' => '106.8532384'
                         ],  ['Content-Type' => 'application/json']);

        $response->assertStatus(201)
                 ->assertJson(['success' => true]);
    }

    /**
     * Test edit building baru
     * 
     * @return void
     */
    public function testModifyNewBuilding()
    {
        $authenticatedUser = \App\Models\User::where('email', 'hello@abdilah.id')->first();

        $user = \App\Models\User::where('email', 'test@abdilah.id')->first();

        $building = \App\Models\Building\Header::where('building_title', 'Kos Mamah Lela')->first();

        $response = $this->actingAs($authenticatedUser, 'api')
                         ->putJson("/building/{$building->id}", [
                            'building_title' => 'Kos Mamah Lela', 
                            'building_address' => 'Jalan Pembina III No.16 RT.05 RW.06 Matraman Jakarta Timur', 
                            'building_desc' => '-'
                        ],  ['Content-Type' => 'application/json']);

        $response->assertStatus(200)
                        ->assertJson(['data' => ['building_desc' => '-']]);
    }

    /**
     * Test delete building baru
     * 
     * @return void
     */
    public function testDeleteNewBuilding()
    {
        $authenticatedUser = \App\Models\User::where('email', 'hello@abdilah.id')->first();

        $header = \App\Models\Building\Header::where('building_title', 'Kos Mamah Lela')->first();

        if (empty($header)) {
            $header = \App\Models\Building\Header::create([
                'building_title' => 'Kos Mamah Lela', 
                'building_address' => 'Jalan Pembina III No.16 RT.05 RW.06 Matraman Jakarta Timur', 
                'building_desc' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
                'building_lat_coordinate' => '-6.2061278',
                'building_long_coordinate' => '106.8532384'
            ]);
        }

        $response = $this->actingAs($authenticatedUser, 'api')
                         ->deleteJson("/building/{$header->id}", [],  ['Content-Type' => 'application/json']);
                        
        $response->assertStatus(410)
                        ->assertJson(['success' => true]);
    }
}
