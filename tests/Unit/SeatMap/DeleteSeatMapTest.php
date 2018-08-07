<?php

namespace Tests\Unit\SeatMap;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteSeatMapTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        \Artisan::call('migrate:refresh', ['--env' => 'testing']);
        \Artisan::call('db:seed', ['--env' => 'testing']);
    }
    
    private function getAdmin()
    {
        return \App\User::where('permission', 1)->first();
    }
    /**
     * Test delete seat map without login
     * 
     * @return void
     */
    public function testAccessDeleteNoLogin()
    {
        $response = $this->post('/seat-map/delete', [
            'SeatmapID' => 2,
            'SeatmapName' => 'a',
        ]);
        $response->assertStatus(302);
    }
    /**
     * Test delete seat map with user privilege
     * 
     * @return void
     */
    public function testAccessDeleteNoPermission()
    {
        $user = \App\User::where('permission', 0)->first();
        $response = $this->actingAs($user)->post('/seat-map/delete', [
            'SeatmapID' => 2,
            'SeatmapName' => 'a',
        ]);
        $response->assertStatus(403);
    }

    /**
     * Test delete seat map with existed id
     * 
     * @return void
     */
    public function testDeleteExistSeatMap()
    {
        $user = $this->getAdmin();
        $response = $this->actingAs($user)->post('/seat-map/delete', [
            'SeatmapID' => 3,
            'SeatmapName' => 'a',
        ]);
        $response->assertSessionHasNoErrors();
    }

    /**
     * Test delete seat map with not existed id
     * 
     * @return void
     */
    public function testDeleteNonExistSeatMap()
    {
        $user = $this->getAdmin();
        $response = $this->actingAs($user)->post('/seat-map/delete', [
            'SeatmapID' => 5694,
            'SeatmapName' => 'a',
        ]);
        $response->assertSessionHasErrors(['SeatmapID']);
    }

     /**
     * Test delete seat map with not invalid id
     * 
     * @return void
     */
    public function testDeleteSeatMapWithInvalidId()
    {
        $user = $this->getAdmin();
        $response = $this->actingAs($user)->post('/seat-map/delete', [
            'SeatmapID' => 'ajjelks',
        ]);
        $response->assertSessionHasErrors(['SeatmapID']);
    }

     /**
     * Test delete seat map with no id
     * 
     * @return void
     */
    public function testDeleteSeatMapWithoutId()
    {
        $user = $this->getAdmin();
        $response = $this->actingAs($user)->post('/seat-map/delete', [
            'SeatmapID' => '',
        ]);
        $response->assertSessionHasErrors(['SeatmapID']);
    }

}
