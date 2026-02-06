<?php

namespace Tests\Feature\Commands;

use App\Models\Link;
use Tests\TestCase;

class CleanupLinksTest extends TestCase
{

    public function test_delete_inactive_links()
    {
        $neverUsed = Link::factory()->create([
            'created_at' => now()->subMonths(4),
            'user_id' => $this->user->id,
            'last_used_at' => null
        ]);

        $oldUsedLongAgo = Link::factory()->create([
            'last_used_at' => now()->subDays(100),
            'user_id' => $this->user->id,
        ]);

        $this->artisan('links:cleanup')
             ->expectsOutputToContain('archived links.')
             ->assertExitCode(0);

        $this->assertSoftDeleted('links', [
            'id' => $neverUsed->id
        ]);

        $this->assertSoftDeleted('links', [
            'id' => $oldUsedLongAgo->id
        ]);

        $this->assertDatabaseHas('links', [
            'id' => $neverUsed->id
        ]);

        $this->assertNotNull(Link::withTrashed()->find($neverUsed->id)->deleted_at);
    }
}