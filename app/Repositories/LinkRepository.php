<?php

namespace App\Repositories\Eloquent;

use App\Models\Link;
use App\Data\LinkData;
use App\Repositories\LinkRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class LinkRepository implements LinkRepositoryInterface
{

    /**
     * @param int $userId
     * @return LengthAwarePaginator
     */
    public function getAllForUser(int $userId): LengthAwarePaginator
    {
        return Link::where('user_id', $userId)->latest()->paginate(10);
    }

    /**
     * @param int $userId
     * @param LinkData $data
     * @return Link
     */
    public function create(int $userId, LinkData $data): Link
    {
        return Link::create([
            'user_id' => $userId,
            'original_url' => $data->original_url,
            'short_code' => $this->generateUniqueCode(),
        ]);
    }

    /**
     * @return string
     * Generate a unique random string
     */
    private function generateUniqueCode(): string
    {
        do {
            $code = Str::random(6);
        } while ($this->findByCode($code) != null);

        return $code;
    }

    /**
     * @param string $code
     * @return ?Link
     */
    public function findByCode(string $code): ?Link
    {
        return Link::withTrashed()->where('short_code', $code)->first();
    }
}