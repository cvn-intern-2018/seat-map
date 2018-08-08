<?php

namespace Tests\Unit\SeatMap;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AddSeatMapTest extends TestCase
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
     * Test add seat map when not login
     *
     * @return void
     */
    public function testAddSeatmapNoLogin()
    {
        $response = $this->post('/seat-map/add', [
            'SeatmapName' => $this->faker->words(3, true),
            'SeatmapPic' => $this->faker->image('public/images/seat-map', 500, 500),
        ]);
        $response->assertStatus(302);
    }

    /**
     * Test add seat map when login with user privilege
     *
     * @return void
     */
    public function testAddSeatmapAsUser()
    {
        $user = \App\User::where('permission', 0)->first();
        $response = $this->actingAs($user)->post('/seat-map/add', [
            'SeatmapName' => $this->faker->words(3, true),
            'SeatmapPic' => $this->faker->image('public/images/seat-map', 500, 500),
        ]);
        $response->assertStatus(403);
    }

    /**
     * Test add seat map when login with admin privilege
     *
     * @return void
     */
    public function testAddSeatmap()
    {
        // Storage::fake("avatar")
        $user = $this->getAdmin();
        $image = UploadedFile::fake()->image('avatar.jpg', 500, 500);

        $response = $this->actingAs($user)->post('/seat-map/add', [
            'SeatmapName' => $this->faker->words(3, true),
            'SeatmapPic' => $image,
        ]);
        $response->assertSessionHasNoErrors();
    }

    /**
     * Test add seat map without name
     *
     * @return void
     */
    public function testAddSeatmapWithNoName()
    {
        // Storage::fake("avatar")
        $user = $this->getAdmin();
        $image = UploadedFile::fake()->image('avatar.jpg', 500, 500);

        $response = $this->actingAs($user)->post('/seat-map/add', [
            'SeatmapName' => '',
            'SeatmapPic' => $image,
        ]);
        $response->assertSessionHasErrors(['SeatmapName']);
    }

    /**
     * Test add seat map with long name
     *
     * @return void
     */
    public function testAddSeatmapWithLongName()
    {
        // Storage::fake("avatar")
        $user = $this->getAdmin();
        $image = UploadedFile::fake()->image('avatar.jpg', 500, 500);

        $response = $this->actingAs($user)->post('/seat-map/add', [
            'SeatmapName' => $this->faker->words(30, true),
            'SeatmapPic' => $image,
        ]);
        $response->assertSessionHasErrors(['SeatmapName']);
    }

    /**
     * Test add seat map with whitespace name
     *
     * @return void
     */
    public function testAddSeatmapWithWhitespaceName()
    {
        // Storage::fake("avatar")
        $user = $this->getAdmin();
        $image = UploadedFile::fake()->image('avatar.jpg', 500, 500);

        $response = $this->actingAs($user)->post('/seat-map/add', [
            'SeatmapName' => '        ',
            'SeatmapPic' => $image,
        ]);
        $response->assertSessionHasErrors(['SeatmapName']);
    }

    /**
     * Test add seat map with small dimentional image
     *
     * @return void
     */
    public function testAddSeatmapWithNoImage()
    {
        $user = $this->getAdmin();

        $response = $this->actingAs($user)->post('/seat-map/add', [
            'SeatmapName' => $this->faker->words(3, true),
            'SeatmapPic' => null,
        ]);
        $response->assertSessionHasErrors(['SeatmapPic']);
    }

    /**
     * Test add seat map with small dimentional image
     *
     * @return void
     */
    public function testAddSeatmapWithSmallImage()
    {
        $user = $this->getAdmin();
        $image = UploadedFile::fake()->image('avatar.jpg', 100, 200);

        $response = $this->actingAs($user)->post('/seat-map/add', [
            'SeatmapName' => $this->faker->words(3, true),
            'SeatmapPic' => $image,
        ]);
        $response->assertSessionHasErrors(['SeatmapPic']);
    }

    /**
     * Test add seat map with large file size
     *
     * @return void
     */
    public function testAddSeatmapWithLargeFile()
    {
        // Storage::fake("avatar")
        $user = $this->getAdmin();
        $image = UploadedFile::fake()->image('avatar.jpg', 300, 300)->size(6144);

        $response = $this->actingAs($user)->post('/seat-map/add', [
            'SeatmapName' => $this->faker->words(3, true),
            'SeatmapPic' => $image,
        ]);
        $response->assertSessionHasErrors(['SeatmapPic']);
    }

}
