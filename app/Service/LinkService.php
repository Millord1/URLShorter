<?php

namespace App\Service;

use App\Repositories\LinkRepositoryInterface;

class LinkService
{
    public function __construct(public LinkRepositoryInterface $linkRepository) {}

    /**
     * @return int
     */
    public function cleanupInactiveLinks(): int
    {
        $threshold = now()->subMonths(3);
        return $this->linkRepository->deleteInactiveSince($threshold);
    }
}