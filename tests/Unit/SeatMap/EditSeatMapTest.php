<?php

namespace Tests\Unit\SeatMap;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EditSeatMapTest extends TestCase
{
    use WithFaker;
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
     * Test edit seat map page when not login
     * 
     * @return void
     */
    public function testEditSeatmapPageNoLogin()
    {
        $map = \App\SeatMap::first();
        $response = $this->get('/seat-map/edit/'.$map->id);
        $response->assertStatus(302);
    }

    /**
     * Test edit seat map page when login with user privilege
     * 
     * @return void
     */
    public function testEditSeatmapPageAsUser()
    {
        $map = \App\SeatMap::first();
        $user = \App\User::where('permission', 0)->first();
        $response = $this->actingAs($user)->get('/seat-map/edit/'.$map->id);
        $response->assertStatus(403);
    }

    /**
     * Test edit seat map page when login with admin privilege
     * 
     * @return void
     */
    public function testEditSeatmapPage()
    {
        $user = $this->getAdmin();
        $map = \App\SeatMap::first();

        $response = $this->actingAs($user)->get('/seat-map/edit/'.$map->id, [
            'seatmap_id' => $map->id,
            'seatmap_name' => $this->faker->words(2, true),
            'seat_data' => json_encode([]),
        ]);
        $response->assertSessionHasNoErrors();
    }

    /**
     * Test edit seat map submit when not login
     * 
     * @return void
     */
    public function testEditSeatmapNoLogin()
    {
        $map = \App\SeatMap::first();
        $response = $this->post('/seat-map/edit');
        $response->assertStatus(302);
    }

    /**
     * Test edit seat map submit when login with user privilege
     * 
     * @return void
     */
    public function testEditSeatmapAsUser()
    {
        $map = \App\SeatMap::first();
        $user = \App\User::where('permission', 0)->first();
        $response = $this->actingAs($user)->post('/seat-map/edit');
        $response->assertStatus(403);
    }

    /**
     * Test edit seat map submit when login with admin privilege
     * 
     * @return void
     */
    public function testEditSeatmap()
    {
        $user = $this->getAdmin();
        $map = \App\SeatMap::first();

        $response = $this->actingAs($user)->post('/seat-map/edit', [
            'seatmap_id' => $map->id,
            'seatmap_name' => $this->faker->words(2, true),
            'seat_data' => json_encode([]),
        ]);
        $response->assertSessionHasNoErrors();
    }

    /**
     * Test edit seat map submit without id
     * 
     * @return void
     */
    public function testEditSeatmapNoId()
    {
        $user = $this->getAdmin();

        $response = $this->actingAs($user)->post('/seat-map/edit', [
            'seatmap_id' => '',
            'seatmap_name' => $this->faker->words(2, true),
            'seat_data' => json_encode([]),
        ]);
        $response->assertSessionHasErrors(['seatmap_id']);
    }

    /**
     * Test edit seat map submit with non-existed id
     * 
     * @return void
     */
    public function testEditSeatmapInvalidId()
    {
        $user = $this->getAdmin();

        $response = $this->actingAs($user)->post('/seat-map/edit', [
            'seatmap_id' => 1536,
            'seatmap_name' => $this->faker->words(2, true),
            'seat_data' => json_encode([]),
        ]);
        $response->assertSessionHasErrors(['seatmap_id']);
    }

    /**
     * Test edit seat map submit without name
     * 
     * @return void
     */
    public function testEditSeatmapNoName()
    {
        $user = $this->getAdmin();
        $map = \App\SeatMap::first();

        $response = $this->actingAs($user)->post('/seat-map/edit', [
            'seatmap_id' => $map->id,
            'seatmap_name' => '',
            'seat_data' => json_encode([]),
        ]);
        $response->assertSessionHasErrors(['seatmap_name']);
    }
    
    /**
     * Test edit seat map submit with long name
     * 
     * @return void
     */
    public function testEditSeatmapLongName()
    {
        $user = $this->getAdmin();
        $map = \App\SeatMap::first();

        $response = $this->actingAs($user)->post('/seat-map/edit', [
            'seatmap_id' => $map->id,
            'seatmap_name' => $this->faker->words(50, true),
            'seat_data' => json_encode([]),
        ]);
        $response->assertSessionHasErrors(['seatmap_name']);
    }

    /**
     * Test edit seat map submit with empty seat data
     * 
     * @return void
     */
    public function testEditSeatmapNoSeatData()
    {
        $user = $this->getAdmin();
        $map = \App\SeatMap::first();

        $response = $this->actingAs($user)->post('/seat-map/edit', [
            'seatmap_id' => $map->id,
            'seatmap_name' => $this->faker->words(2, true),
            'seat_data' => '',
        ]);
        $response->assertSessionHasNoErrors();
    }

    
    /**
     * Test edit seat map submit with invalid seat data
     * 
     * @return void
     */
    public function testEditSeatmapInvalidSeatData()
    {
        $user = $this->getAdmin();
        $map = \App\SeatMap::first();

        $response = $this->actingAs($user)->post('/seat-map/edit', [
            'seatmap_id' => $map->id,
            'seatmap_name' => $this->faker->words(2, true),
            'seat_data' => $this->faker->words(2, true),
        ]);
        $response->assertSessionHasErrors(['seat_data']);
    }

    /**
     * Test edit seat map submit with seat data has invalid user
     * 
     * @return void
     */
    public function testEditSeatmapInvalidUser()
    {
        $user = $this->getAdmin();
        $map = \App\SeatMap::first();

        $response = $this->actingAs($user)->post('/seat-map/edit', [
            'seatmap_id' => $map->id,
            'seatmap_name' => $this->faker->words(2, true),
            'seat_data' => json_encode([
                [
                    'user_id' => 5421,
                    'x' => 63.00,
                    'y' => 41.25,
                ]
            ]),
        ]);
        $response->assertSessionHasNoErrors();
    }

    /**
     * Test edit seat map submit with seat data has invalid coordination
     * 
     * @return void
     */
    public function testEditSeatmapInvalidCoordination()
    {
        $user = $this->getAdmin();
        $map = \App\SeatMap::first();

        $response = $this->actingAs($user)->post('/seat-map/edit', [
            'seatmap_id' => $map->id,
            'seatmap_name' => $this->faker->words(2, true),
            'seat_data' => json_encode([
                [
                    'user_id' => 5,
                    'x' => 63000,
                    'y' => 412500,
                ]
            ]),
        ]);
        $response->assertSessionHasErrors();
    }
}
