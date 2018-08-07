<?php

namespace Tests\Unit\Group;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddGroupTest extends TestCase
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
     * Test add group without login
     * 
     * @return void
     */
    public function testAccessAddNoLogin()
    {
        $response = $this->post('/group-setting/new', [
            'group_id' => 2,
            'group_name' => 'New name',
        ]);
        $response->assertStatus(302);
    }

    /**
     * Test add group with user privilege
     * 
     * @return void
     */
    public function testAccessAddNoPermission()
    {
        $user = \App\User::where('permission', 0)->first();
        $response = $this->actingAs($user)->post('/group-setting/new', [
            'group_id' => 2,
            'group_name' => 'New name',
        ]);
        $response->assertStatus(403);
    }

    /**
     * Test add new group with existed name
     * 
     * @return void
     */
    public function testAddExistedGroup()
    {
        $user = $this->getAdmin();
        $group = \App\UserGroup::first();
        $response = $this->actingAs($user)->post('/group-setting/new', [
            'group_name' => $group->name,
        ]);
        $response->assertSessionHasErrors(['group_name']);
    }

    /**
     * Test add new group with available name
     * 
     * @return void
     */
    public function testAddAvailableGroup()
    {
        $user = $this->getAdmin();
        $response = $this->actingAs($user)->post('/group-setting/new', [
            'group_name' => $this->faker->words(3, true),
        ]);
        $response->assertSessionHasNoErrors();
    }

    /**
     * Test add new group with no name
     * 
     * @return void
     */
    public function testAddNoNameGroup()
    {
        $user = $this->getAdmin();
        $response = $this->actingAs($user)->post('/group-setting/new', [
            'group_name' => '',
        ]);
        $response->assertSessionHasErrors(['group_name']);
    }

    /**
     * Test add new group with name longer than 100 characters
     * 
     * @return void
     */
    public function testAddLongNameGroup()
    {
        $user = $this->getAdmin();
        $response = $this->actingAs($user)->post('/group-setting/new', [
            'group_name' => $this->faker->words(30, true),
        ]);
        $response->assertSessionHasErrors(['group_name']);
    }

    /**
     * Test add new group with name with whitespace characters only
     * 
     * @return void
     */
    public function testAddWhitespaceNameGroup()
    {
        $user = $this->getAdmin();
        $response = $this->actingAs($user)->post('/group-setting/new', [
            'group_name' => '            ',
        ]);
        $response->assertSessionHasErrors(['group_name']);
    }
}
