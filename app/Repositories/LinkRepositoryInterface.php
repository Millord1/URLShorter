<?php

namespace App\Repositories;

use App\Models\Link;
use App\Data\LinkData;
use Illuminate\Pagination\LengthAwarePaginator;

interface LinkRepositoryInterface
{
    public function getAllForUser(int $userId): LengthAwarePaginator;
    public function create(int $userId, LinkData $data): Link;
    public function findByCode(string $code): ?Link;
}