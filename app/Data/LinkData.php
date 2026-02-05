<?php

namespace App\Data;

use App\Models\Link;
use DateTime;
use Spatie\LaravelData\Data;

class LinkData extends Data
{

    public function __construct(
        public ?int $id,
        public int $user_id,
        public string $short_code,
        public string $original_url,
        public int $clicks_count,
        public DateTime $last_used_at,
        public DateTime $created_at,
        public DateTime $updated_at,
        public DateTime $deleted_at
    ){}

    /**
     * @param Link $model
     * @return LinkData
     */
    public static function fromModel(Link $model): LinkData
    {
        return new LinkData(
            $model->id,
            $model->userId,
            $model->shortCode,
            $model->originalUrl,
            $model->clicksCount,
            $model->lastUsedAt,
            $model->createdAt,
            $model->updatedAt,
            $model->deletedAt
        );
    }

    public static function rules(): array
    {
        return [
            'original_url' => ['required', 'url', 'active_url'],  
        ];
    }
}