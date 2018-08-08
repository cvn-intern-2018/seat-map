<?php

namespace Tests\Unit\User;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;

class AddUserTest extends TestCase
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
     * Test add user without login
     *
     * @return void
     */
    public function testAccessAddNoLogin()
    {
        $response = $this->post('/users/add', [
            'username' => 'New name',
        ]);
        $response->assertStatus(302);
    }

    /**
     * Test add user with user privilege
     *
     * @return void
     */
    public function testAccessAddNoPermission()
    {
        $user = \App\User::where('permission', 0)->first();
        $response = $this->actingAs($user)->post('/users/add', [
            'username' => 'New name',
        ]);
        $response->assertStatus(403);
    }

    /**
     * Test add user
     *
     * @return void
     */
    public function testAddUser()
    {
        $user = $this->getAdmin();
        $image = UploadedFile::fake()->image('avatar.jpg', 500, 500);
        $response = $this->actingAs($user)->post('/users/add', [
            'username' => $this->faker->userName,
            'fullname' => $this->faker->name,
            'password' => 'secret',
            'email' => $this->faker->unique()->safeEmail,
            'short_name' => substr($this->faker->lastName, 0, 10),
            'phone' => '0123456789',
            'avatar' => $image,
            'group_id' => 1,
        ]);
        $response->assertJsonStructure([
            'status'
        ]);
    }

    /**
     * Test add user with empty field
     *
     * @return void
     */
    public function testAddUserWithEmptyFields()
    {
        $user = $this->getAdmin();
        $image = UploadedFile::fake()->create('test.txt', 5);
        $response = $this->actingAs($user)->post('/users/add', [
            'username' => '',
            'fullname' => '',
            'password' => '',
            'email' => '',
            'short_name' => $this->faker->words(5, true),
            'phone' => '',
            'avatar' => $image,
            'group_id' => 1,
        ]);
        $response->assertJsonStructure([
            'status',
            'userInforErr' => [
                'usernameErr',
                'fullnameErr',
                'passwordErr',
                'emailErr',
                'shortnameErr',
                'phoneErr',
                'imageErr'
            ]
        ]);
    }
}
