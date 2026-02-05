<?php

namespace App\Console\Commands;

use App\Models\Link;
use App\Service\LinkService;
use Illuminate\Console\Command;

class CleanUpLinks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clean-up-links';

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
