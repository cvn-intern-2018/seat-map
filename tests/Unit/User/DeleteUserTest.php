<?php

namespace Tests\Unit\User;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteUserTest extends TestCase
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
    public function testAccessDeleteNoLogin()
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
    public function testAccessDeleteNoPermission()
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
    public function testDeleteUser()
    {
        $user = $this->getAdmin();
        $target = \App\User::where('username', '!=', 'admin')->first();
        $response = $this->actingAs($user)->post('/users/edit', [
            'username' => $target->username,
        ]);
        $response->assertSessionHas('prv_error', '');

    }

    /**
     * Test edit user without user id
     * 
     * @return void
     */
    public function testDeleteUserWithEmptyUsername()
    {
        $user = $this->getAdmin();
        $response = $this->actingAs($user)->post('/users/edit', [
            'username' => '',
        ]);
        $response->assertStatus(404);
    }

    /**
     * Test edit user with non-exist user id
     * 
     * @return void
     */
    public function testDeleteUserWithNonExistUsername()
    {
        $user = $this->getAdmin();
        $response = $this->actingAs($user)->post('/users/edit', [
            'username' => $this->faker->userName,
        ]);
        $response->assertStatus(404);
    }
}
