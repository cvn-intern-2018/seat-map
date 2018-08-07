<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteGroupTest extends TestCase
{
    /**
     * Test delete group without login
     * 
     * @return void
     */
    public function testAccessDeleteNoLogin()
    {
        $response = $this->post('/group-setting/delete', [
            'group_id' => 2,
        ]);
        $response->assertStatus(302);
    }
    /**
     * Test delete group with user privilege
     * 
     * @return void
     */
    public function testAccessDeleteNoPermission()
    {
        $user = \App\User::where('permission', 0)->first();
        $response = $this->actingAs($user)->post('/group-setting/delete', [
            'group_id' => 2,
        ]);
        $response->assertStatus(403);
    }

    /**
     * Test delete group with existed id not 1
     * 
     * @return void
     */
    public function testDeleteExistGroup()
    {
        $user = $this->getAdmin();
        $response = $this->actingAs($user)->post('/group-setting/delete', [
            'group_id' => 3,
        ]);
        $response->assertSessionHasNoErrors();
    }

    /**
     * Test delete group with not existed id
     * 
     * @return void
     */
    public function testDeleteNonExistGroup()
    {
        $user = $this->getAdmin();
        $response = $this->actingAs($user)->post('/group-setting/delete', [
            'group_id' => 5694,
        ]);
        $response->assertSessionHasErrors(['group_id']);
    }

    
    /**
     * Test delete group with id = 1
     * 
     * @return void
     */
    public function testDeleteUnassignedGroup()
    {
        $user = $this->getAdmin();
        $response = $this->actingAs($user)->post('/group-setting/delete', [
            'group_id' => 1,
        ]);
        $response->assertSessionHasErrors(['group_id']);
    }

    private function getAdmin()
    {
        return \App\User::where('permission', 1)->first();
    }
}
