<?php

namespace App\Services;

use App\Data\LinkData;
use App\Models\Link;
use App\Repositories\LinkRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class LinkService
{

    public function __construct(
        public LinkRepository $repository,
        public CodeGenerator $generator,
    ) {}

    /**
     * @param int $userId
     * @return LengthAwarePaginator
     */
    public function getAllForUser(int $userId): LengthAwarePaginator
    {
        return $this->repository->paginateForUser($userId);
    }

    /**
     * @param int $userId
     * @param string $originalUrl
     * @return Link
     */
    public function create(int $userId, string $originalUrl): Link
    {
        $data = LinkData::from([
            'user_id' => $userId,
            'original_url' => $originalUrl,
            'short_code' => 'temp',
        ]);

        return DB::transaction(function () use ($data) {
            $link = $this->repository->create($data);

            // Use offset to have at least 6 chars on every short_code
            $offset = 1000000000; 
            $shortCode = $this->generator->encode($link->id + $offset);
            
            $link->update(['short_code' => $shortCode]);

            return $link;
        });
    }

    /**
     * @param string $code
     * @return ?LinkData
     */
    public function findByCode(string $code): ?LinkData
    {
        $link = $this->repository->findByCode($code, false);
        return $link ? LinkData::fromModel($link) : null;
    }

    /**
     * @param string $code
     * @return ?LinkData
     */
    public function findByCodeWithTrashed(string $code): ?LinkData
    {
        $link = $this->repository->findByCode($code, true);
        return $link ? LinkData::fromModel($link) : null;
    }

    /**
     * @param int $linkId
     * @param string $newUrl
     * @return void
     */
    public function update(LinkData $data): void
    {
        $this->repository->update($data);
    }

    /**
     * @return int
     */
    public function cleanupInactiveLinks(): int
    {
        $threshold = now()->subMonths(3);
        return $this->repository->deleteInactive($threshold);
    }

    /**
     * @param int $id
     */
    public function trackClick(int $id): void
    {
        $this->repository->incrementClicks($id);
    }

    /**
     * @param LinkData $data
     * @return bool
     */
    public function delete(LinkData $data): bool
    {
        return $this->repository->delete($data);
    }
}