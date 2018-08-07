<?php

namespace Tests\Unit\SeatMap;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SeatMapTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        \Artisan::call('migrate:refresh', ['--env' => 'testing']);
        \Artisan::call('db:seed', ['--env' => 'testing']);
    }

    /**
     * Test view a seat map.
     *
     * @return void
     */
    public function testViewSeatmap()
    {
        $seatmap = \App\SeatMap::first();
        $response = $this->get('/seat-map/'.$seatmap->id);
        $response->assertStatus(200);
    }

    /**
     * Test view non-existed seat map.
     *
     * @return void
     */
    public function testViewNonExistedSeatmap()
    {
        $response = $this->get('/seat-map/4526');
        $response->assertStatus(404);
    }

    /**
     * Test view non-existed seat map.
     *
     * @return void
     */
    public function testViewSeatmapWithFloatId()
    {
        $seatmap = \App\SeatMap::first();
        $response = $this->get('/seat-map/'.$seatmap->id.'.000');
        $response->assertStatus(404);
    }
}
