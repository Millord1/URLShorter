<?php

namespace Tests\Feature;

use App\Models\Link;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LinkControlerTest extends TestCase
{
    use RefreshDatabase;

    private Link $link;

    protected function setUp(): void
    {
        parent::setUp();

        $this->link = Link::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $this->actingAs($this->user);
    }

    public function test_store_link(): void
    {
        $url = 'https://myanapro.com/';
        $payload = [
            'original_url' => $url,
        ];

        $response = $this->post('/links', $payload);

        $response->assertRedirect(route('links.index'));
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('links', [
            'original_url' => $url,
            'user_id' => $this->user->id,
        ]);

        $link = Link::first();
        $this->assertNotNull($link->short_code);
        $this->assertEquals(6, strlen($link->short_code));
    }

    public function test_update_link(): void
    {
        $originalUrl = $this->link->original_url;

        $url = 'https://google.com/';

        $this->assertNotEquals($originalUrl, $url);

        $payload = [
            'original_url' => $url,
        ];

        $response = $this->patch('/links/'.$this->link->id, $payload);
        $response->assertRedirect(route('links.index'));
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('links', [
            'original_url' => $url,
            'user_id' => $this->user->id,
        ]);

        $link = Link::findOrFail($this->link->id);
        $this->assertEquals($url, $link->original_url);

        $this->assertDatabaseMissing('links', [
            'original_url' => $originalUrl,
            'user_id' => $this->user->id,
        ]);
    }

    public function test_user_cannot_delete_others_link(): void
    {
        $otherUser = User::factory()->create();
        $link = Link::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->delete('/links/'.$link->id);

        $response->assertStatus(403);
        $this->assertDatabaseHas('links', ['id' => $link->id, 'deleted_at' => null]);
    }

    public function test_destroy_link(): void
    {
        $linkId = $this->link->id;

        $response = $this->delete('/links/'.$linkId);

        $response->assertRedirect(route('links.index'));
        $response->assertSessionHasNoErrors();

        $this->assertSoftDeleted('links', [
            'id' => $linkId,
        ]);

    }
}
