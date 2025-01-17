<?php

declare(strict_types=1);

namespace HetznerCloud\ValueObjects;

use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;

/**
 * @phpstan-type PaginationSchema array{
 *     page: int,
 *     per_page: int,
 *     previous_page?: int,
 *     next_page?: int,
 *     last_page?: int,
 *     total_entries?: int,
 * }
 *
 * @implements ResponseContract<PaginationSchema>
 */
final readonly class Pagination implements ResponseContract
{
    /**
     * @use ArrayAccessible<PaginationSchema>
     */
    use ArrayAccessible;

    public function __construct(
        public int $page,
        public int $perPage,
        public ?int $previousPage,
        public ?int $nextPage,
        public ?int $lastPage,
        public ?int $totalEntries,
    ) {
        //
    }

    /**
     * @param  PaginationSchema  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            $attributes['page'],
            $attributes['per_page'],
            $attributes['previous_page'] ?? null,
            $attributes['next_page'] ?? null,
            $attributes['last_page'] ?? null,
            $attributes['total_entries'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'page' => $this->page,
            'per_page' => $this->perPage,
            'previous_page' => $this->previousPage,
            'next_page' => $this->nextPage,
            'last_page' => $this->lastPage,
            'total_entries' => $this->totalEntries,
        ];
    }
}
