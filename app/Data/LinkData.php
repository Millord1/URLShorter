<?php

namespace App\Data;

use App\Models\Link;
use DateTime;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class LinkData extends Data
{

    public function __construct(
        public readonly ?int $id,
        public readonly int|Optional $user_id,
        public readonly string|Optional $short_code,
        public readonly string $original_url,
        public readonly int|Optional $clicks_count,
        public readonly ?string $last_used_at,
        public readonly ?string $created_at,
        public readonly ?string $updated_at,
        public readonly ?string $deleted_at
    ){}

    /**
     * @param Link $model
     * @return LinkData
     */
    public static function fromModel(Link $model): LinkData
    {
        return new LinkData(
            $model->id,
            $model->user_id,
            $model->short_code,
            $model->original_url,
            $model->clicks_count,
            $model->last_used_at,
            $model->created_at,
            $model->updated_at,
            $model->deleted_at
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'short_code' => $this->short_code,
            'original_url' => $this->original_url,
            'clicks_count' => $this->clicks_count,
            'last_used_at' => $this->last_used_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    /**
     * @return array
     */
    public function toUpdate(): array
    {
        return [
            'original_url' => $this->original_url,
        ];
    }

    /**
     * @return array
     */
    public function toCreate(): array
    {
        return [
            'user_id' => $this->user_id,
            'original_url' => $this->original_url,
            'short_code' => $this->short_code,
        ];
    }
}