<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EditGroupTest extends TestCase
{
    use WithFaker;
    /**
     * Test edit group without login
     * 
     * @return void
     */
    public function testAccessEditNoLogin()
    {
        $response = $this->post('/group-setting/edit', [
            'group_id' => 2,
            'group_name' => 'New name',
        ]);
        $response->assertStatus(302);
    }

    /**
     * Test edit group with user privilege
     * 
     * @return void
     */
    public function testAccessEditNoPermission()
    {
        $user = \App\User::where('permission', 0)->first();
        $response = $this->actingAs($user)->post('/group-setting/edit', [
            'group_id' => 2,
            'group_name' => 'New name',
        ]);
        $response->assertStatus(403);
    }
    
    /**
     * Test edit group with existed name
     * 
     * @return void
     */
    public function testEditExistedGroup()
    {
        $user = $this->getAdmin();
        $group = \App\UserGroup::first();
        $response = $this->actingAs($user)->post('/group-setting/edit', [
            'group_id' => 3,
            'group_name' => $group->name,
        ]);
        $response->assertSessionHasErrors(['group_name']);
    }

    /**
     * Test edit group with available name
     * 
     * @return void
     */
    public function testEditAvailableGroup()
    {
        $user = $this->getAdmin();
        $response = $this->actingAs($user)->post('/group-setting/edit', [
            'group_id' => 3,
            'group_name' => $this->faker->words(3, true),
        ]);
        $response->assertSessionHasNoErrors();
    }

    /**
     * Test edit group with no name
     * 
     * @return void
     */
    public function testEditNoNameGroup()
    {
        $user = $this->getAdmin();
        $response = $this->actingAs($user)->post('/group-setting/edit', [
            'group_id' => 3,
            'group_name' => '',
        ]);
        $response->assertSessionHasErrors(['group_name']);
    }

    /**
     * Test edit group with name longer than 100 characters
     * 
     * @return void
     */
    public function testEditLongNameGroup()
    {
        $user = $this->getAdmin();
        $response = $this->actingAs($user)->post('/group-setting/edit', [
            'group_id' => 3,
            'group_name' => $this->faker->words(30, true),
        ]);
        $response->assertSessionHasErrors(['group_name']);
    }

    /**
     * Test edit group with name with whitespace characters only
     * 
     * @return void
     */
    public function testEditWhitespaceNameGroup()
    {
        $user = $this->getAdmin();
        $response = $this->actingAs($user)->post('/group-setting/edit', [
            'group_id' => 3,
            'group_name' => '            ',
        ]);
        $response->assertSessionHasErrors(['group_name']);
    }

    
    /**
     * Test edit group with name same as old name
     * 
     * @return void
     */
    public function testEditSameNameGroup()
    {
        $user = $this->getAdmin();
        $group = \App\UserGroup::find(3);
        $response = $this->actingAs($user)->post('/group-setting/edit', [
            'group_id' => 3,
            'group_name' => $group->name,
        ]);
        $response->assertSessionHasNoErrors();
    }

    private function getAdmin()
    {
        return \App\User::where('permission', 1)->first();
    }
}
