<?php

namespace App\Repositories;

use App\Data\LinkData;
use App\Models\Link;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class LinkRepository
{

    /**
     * @param int $userId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function paginateForUser(int $userId, int $perPage = 10): LengthAwarePaginator
    {
        return Link::where('user_id', $userId)->latest()->paginate($perPage);
    }

    /**
     * @param LinkData $data
     * @return Link
     */
    public function create(LinkData $data): Link
    {
        return Link::create($data->toCreate());
    }

    /**
     * @param int $id
     * @return Link|null
     */
    public function findByCode(string $code, bool $includeTrashed = true): ?Link
    {
        $query = Link::query();
        if($includeTrashed){
            $query->withTrashed();
        }
        return $query->where('short_code', $code)->first();
    }

    /**
     * @param int $id
     * @return Link
     */
    public function update(LinkData $data): void
    {
        $link = Link::findOrFail($data->id);
        $link->update([
            'original_url' => $data->original_url,
        ]);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function incrementClicks(int $id): void
    {
        Link::where('id', $id)->update([
            'clicks_count' => DB::raw('clicks_count + 1'),
            'last_used_at' => now(),
        ]);
    }

    /**
     * @param LinkData $data
     * @return bool
     */
    public function delete(LinkData $data): bool
    {
        $link = Link::findOrFail($data->id);
        return $link->delete();
    }


    /**
     * @param int $id
     * @return bool
     */
    public function deleteInactive(\DateTime $date): int
    {
        return Link::where(function ($query) use ($date) {
            $query->where('last_used_at', '<', $date)
                ->orWhere(function ($q) use ($date) {
                    $q->whereNull('last_used_at')->where('created_at', '<', $date);
                });
        })->delete();
    }
}