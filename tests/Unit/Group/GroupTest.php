<?php

namespace Tests\Unit\Group;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Faker\Generator as Faker;

class GroupTest extends TestCase
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
     * Test accessing group setting page without login
     * 
     * @return void
     */
    public function testAccessSettingNoLogin()
    {
        $response = $this->get('/group-setting', [
            'group_id' => 2,
            'group_name' => 'New name',
        ]);
        $response->assertStatus(302);
    }

    /**
     * Test accessing group setting page with user privilege
     * 
     * @return void
     */
    public function testAccessNoPermission()
    {
        $user = \App\User::where('permission', 0)->first();
        $response = $this->actingAs($user)->get('/group-setting', [
            'group_id' => 2,
            'group_name' => 'New name',
        ]);
        $response->assertStatus(403);
    }

    /**
     * Test accessing group setting page with admin privilege
     * 
     * @return void
     */
    public function testAccessWithPermission()
    {
        $user = $this->getAdmin();
        $response = $this->actingAs($user)->get('/group-setting', [
            'group_id' => 2,
            'group_name' => 'New name',
        ]);
        $response->assertStatus(200);
    }

    /**
     * Get and admin user
     */
    private function getAdmin()
    {
        return \App\User::where('permission', 1)->first();
    }
}
