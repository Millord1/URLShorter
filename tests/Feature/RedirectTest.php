<?php

namespace Tests\Feature;

use App\Models\Link;
use Tests\TestCase;

class RedirectTest extends TestCase
{

    public function test_redirect_and_track_clicks(): void
    {
        $response = $this->get('/'.$this->link->short_code);

        $response->assertRedirect($this->link->original_url);

        $this->assertDatabaseHas('links', [
            'id' => $this->link->id,
            'clicks_count' => 1,
        ]);
        
        $this->assertNotNull($this->link->fresh()->last_used_at);
    }

    public function test_redirect_for_non_existant_code()
    {
        $response = $this->get('/notfound');

        $response->assertStatus(200);
        $response->assertViewIs('links.invalid');
    }

    public function test_soft_deleted_links()
    {
        $link = Link::factory()->create([
            'short_code' => 'deleted',
            'user_id' => $this->user->id,
            'deleted_at' => now(), 
        ]);

        $response = $this->get('/'.$link->short_code);

        $response->assertViewIs('links.invalid');
    }
}