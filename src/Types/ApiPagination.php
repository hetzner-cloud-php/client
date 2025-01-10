<?php

declare(strict_types=1);

namespace HetznerCloud\Types;

/**
 * @phpstan-type ApiPaginationResponseSchema array{
 *     page: positive-int,
 *     per_page: positive-int,
 *     previous_page: positive-int,
 *     next_page: positive-int,
 *     last_page: positive-int,
 *     total_entries: positive-int,
 * }
 */
final class ApiPagination {}
