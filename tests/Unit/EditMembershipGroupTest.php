<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EditMembershipGroupTest extends TestCase
{ 
    /**
     * Test edit group with user privilege
     * 
     * @return void
     */
    public function testAccessUpdateNoPermission()
    {
        $user = \App\User::where('permission', 0)->first();
        $response = $this->actingAs($user)->post('/group-setting/update-user', [
            'group_id' => 2,
            'group_name' => 'New name',
        ]);
        $response->assertStatus(403);
    }
}
