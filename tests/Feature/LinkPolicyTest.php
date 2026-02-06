<?php

namespace Tests\Feature\Policies;

use App\Models\Link;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LinkPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_can_update_delete_link()
    {
        $link = Link::factory()->create(['user_id' => $this->user->id]);

        $this->assertTrue($this->user->can('update', $link));
        $this->assertTrue($this->user->can('delete', $link));
    }

    public function test_user_cannot_update_delete_link()
    {
        $otherUser = User::factory()->create();
        $link = Link::factory()->create(['user_id' => $otherUser->id]);

        $this->assertFalse($this->user->can('update', $link));
        $this->assertFalse($this->user->can('delete', $link));
    }
}