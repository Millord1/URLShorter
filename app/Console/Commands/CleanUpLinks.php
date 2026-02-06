<?php

namespace App\Console\Commands;

use App\Services\LinkService;
use Illuminate\Console\Command;

class CleanUpLinks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'links:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean all inactive links since 3 months';

    /**
     * Execute the console command.
     */
    public function handle(LinkService $linkService)
    {
        $count = $linkService->cleanupInactiveLinks();
        $this->info("Cleaned : $count archived links.");
    }
}
