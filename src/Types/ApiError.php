<?php

declare(strict_types=1);

namespace HetznerCloud\Types;

/**
 * @phpstan-type ApiErrorResponseSchema array{
 *     code: string,
 *     message: string,
 *     details: ?array{string, mixed}
 * }
 */
final class ApiError {}
