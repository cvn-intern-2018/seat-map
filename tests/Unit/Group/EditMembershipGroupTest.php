<?php

namespace Tests\Unit\Group;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EditMembershipGroupTest extends TestCase
{
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
     * Test edit group without login
     *
     * @return void
     */
    public function testAccessUpdateNoLogin()
    {
        $response = $this->post('/group-setting/update-user', [
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
    public function testAccessUpdateNoPermission()
    {
        $user = \App\User::where('permission', 0)->first();
        $response = $this->actingAs($user)->post('/group-setting/update-user', [
            'group_id' => 2,
            'group_name' => 'New name',
        ]);
        $response->assertStatus(403);
    }

    /**
     * test a valid update
     *
     * @return void
     */
    public function testUpdateGroup()
    {
        $user = $this->getAdmin();
        $add = \App\User::select(['id'])->where('user_group_id', 2)->take(3)->get()->toArray();
        $remove = \App\User::select(['id'])->where('user_group_id', 3)->take(3)->get()->toArray();
        $response = $this->actingAs($user)->post('/group-setting/update-user', [
            'user_group_id' => 3,
            'user_group_data' => json_encode([
                'add' => $add,
                'remove' => $remove,
            ]),
        ]);
        $response->assertSessionHasNoErrors();
    }

    /**
     * test a invalid update
     *
     * @return void
     */
    public function testInvalidUpdateGroup()
    {
        $user = $this->getAdmin();
        $add = \App\User::select(['id'])->where('user_group_id', 2)->take(3)->get()->toArray();
        $remove = \App\User::select(['id'])->where('user_group_id', 3)->take(3)->get()->toArray();
        $response = $this->actingAs($user)->post('/group-setting/update-user', [
            'user_group_id' => 3,
            'user_group_data' => 'hello world',
        ]);
        $response->assertSessionHasErrors(['user_group_data']);
    }

    /**
     * Test update a user group to non existed group
     *
     * @return void
     */
    public function testUpdateNonExistGroup()
    {
        $user = $this->getAdmin();
        $add = \App\User::select(['id'])->where('user_group_id', 2)->take(3)->get()->toArray();
        $remove = \App\User::select(['id'])->where('user_group_id', 952)->take(3)->get()->toArray();
        $response = $this->actingAs($user)->post('/group-setting/update-user', [
            'user_group_id' => 952,
            'user_group_data' => json_encode([
                'add' => $add,
                'remove' => $remove,
            ]),
        ]);
        $response->assertSessionHasErrors(['user_group_id']);
    }

    /**
     * Test update a user group to non existed group
     *
     * @return void
     */
    public function testUpdateNonExistUser()
    {
        $user = $this->getAdmin();
        $add = [192, 157];
        $remove = [569, 586];
        $response = $this->actingAs($user)->post('/group-setting/update-user', [
            'user_group_id' => 2,
            'user_group_data' => json_encode([
                'add' => $add,
                'remove' => $remove,
            ]),
        ]);
        $response->assertSessionHasNoErrors();
    }

    /**
     * Test remove user from unassigned group
     *
     * @return void
     */
    public function testUpdateRemoveFromUnassigned()
    {
        $user = $this->getAdmin();
        $remove = \App\User::select(['id'])->where('user_group_id', 1)->take(3)->get()->toArray();
        $response = $this->actingAs($user)->post('/group-setting/update-user', [
            'user_group_id' => 1,
            'user_group_data' => json_encode([
                'add' => [],
                'remove' => $remove,
            ]),
        ]);
        $response->assertSessionHasErrors(['user_group_id']);
    }
}
