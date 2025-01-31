<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Models;

use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;

/**
 * @phpstan-import-type PaginationSchema from Pagination
 *
 * @phpstan-type MetaSchema array{pagination: PaginationSchema}
 *
 * @implements ResponseContract<MetaSchema>
 */
final readonly class Meta implements ResponseContract
{
    /**
     * @use ArrayAccessible<MetaSchema>
     */
    use ArrayAccessible;

    public function __construct(
        public Pagination $pagination,
    ) {
        //
    }

    /**
     * @param  MetaSchema  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(Pagination::from($attributes['pagination']));
    }

    public function toArray(): array
    {
        return [
            'pagination' => $this->pagination->toArray(),
        ];
    }
}
