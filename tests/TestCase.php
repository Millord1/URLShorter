<?php

namespace Tests;

use App\Models\Link;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Link $link;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();

        $this->link = Link::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $this->actingAs($this->user);
    }
}
