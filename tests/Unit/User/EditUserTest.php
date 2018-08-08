<?php

namespace Tests\Unit\User;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;

class EditUserTest extends TestCase
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
     * Test edit user without login
     * 
     * @return void
     */
    public function testAccessEditNoLogin()
    {
        $response = $this->post('/users/edit', [
            'username' => 'New name',
        ]);
        $response->assertStatus(302);
    }

    /**
     * Test edit user with user privilege
     * 
     * @return void
     */
    public function testAccessEditNoPermission()
    {
        $user = \App\User::where('permission', 0)->first();
        $response = $this->actingAs($user)->post('/users/edit', [
            'username' => 'New name',
        ]);
        $response->assertStatus(403);
    }

    /**
     * Test edit user 
     * 
     * @return void
     */
    public function testEditUser()
    {
        $user = $this->getAdmin();
        $image = UploadedFile::fake()->image('avatar.jpg', 500, 500);
        $response = $this->actingAs($user)->post('/users/edit', [
            'user_id' => 3,
            'fullname' => $this->faker->name,
            'password' => 'secret',
            'email' => $this->faker->unique()->safeEmail,
            'short_name' => substr($this->faker->lastName, 0, 10),
            'phone' => '0123456789',
            'avatar' => $image,
            'group_id' => 1,
        ]);
        $response->assertSessionHas('prv_error', '');
    }

    /**
     * Test edit user without user id
     * 
     * @return void
     */
    public function testEditUserWithEmptyId()
    {
        $user = $this->getAdmin();
        $image = UploadedFile::fake()->create('test.txt', 5);
        $response = $this->actingAs($user)->post('/users/edit', [
            'user_id' => '',
        ]);
        $response->assertStatus(404);
    }

    /**
     * Test edit user with non-exist user id
     * 
     * @return void
     */
    public function testEditUserWithNonExistId()
    {
        $user = $this->getAdmin();
        $image = UploadedFile::fake()->create('test.txt', 5);
        $response = $this->actingAs($user)->post('/users/edit', [
            'user_id' => 142563,
            'username' => $this->faker->userName,
            'fullname' => $this->faker->name,
            'password' => 'secret',
            'email' => $this->faker->unique()->safeEmail,
            'short_name' => substr($this->faker->lastName, 0, 10),
            'phone' => '0123456789',
            'avatar' => $image,
            'group_id' => 1,
        ]);
        $response->assertStatus(404);
    }

    /**
     * Test edit user with empty field
     * 
     * @return void
     */
    public function testEditUserWithEmptyFields()
    {
        $user = $this->getAdmin();
        $image = UploadedFile::fake()->create('test.txt', 5);
        $response = $this->actingAs($user)->post('/users/edit', [
            'user_id' => 3,
            'fullname' => '',
            'password' => '',
            'email' => '',
            'short_name' => $this->faker->words(5, true),
            'phone' => '',
            'avatar' => $image,
            'group_id' => 1,
        ]);
        $response->assertSessionHas('prv_error');
    }

    /**
     * Test edit user with existed username and email
     * 
     * @return void
     */
    public function testEditUserWithUniqueField()
    {
        $user = $this->getAdmin();
        $image = UploadedFile::fake()->image('avatar.jpg', 500, 500);
        $response = $this->actingAs($user)->post('/users/edit', [
            'user_id' => 3,
            'fullname' => $this->faker->name,
            'password' => 'secret',
            'email' => $user->email,
            'short_name' => substr($this->faker->lastName, 0, 10),
            'phone' => '0123456789',
            'avatar' => $image,
            'group_id' => 1,
        ]);
        $response->assertSessionHas('prv_error');
    }

    /**
     * Test edit user's username
     * 
     * @return void
     */
    public function testEditUserChangeUsername()
    {
        $user = $this->getAdmin();
        $image = UploadedFile::fake()->image('avatar.jpg', 500, 500);
        $response = $this->actingAs($user)->post('/users/edit', [
            'user_id' => 3,
            'username' => $this->faker->userName,
            'fullname' => $this->faker->name,
            'password' => 'secret',
            'email' => $this->faker->unique()->safeEmail,
            'short_name' => substr($this->faker->lastName, 0, 10),
            'phone' => '0123456789',
            'avatar' => $image,
            'group_id' => 1,
        ]);
        $response->assertSessionHas('prv_error');
    }
}
