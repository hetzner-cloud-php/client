<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Datacenters;

use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;
use HetznerCloud\Responses\Datacenters\Models\Datacenter;
use HetznerCloud\Responses\Errors\Error;
use HetznerCloud\Responses\Errors\ErrorResponse;
use Override;

/**
 * @phpstan-import-type DatacenterSchema from Datacenter
 * @phpstan-import-type ErrorResponseSchema from ErrorResponse
 *
 * @phpstan-type GetDatacenterResponseSchema array{
 *     datacenter: ?DatacenterSchema
 * }|ErrorResponseSchema
 *
 * @implements ResponseContract<GetDatacenterResponseSchema>
 */
final readonly class GetDatacenterResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<GetDatacenterResponseSchema>
     */
    use ArrayAccessible;

    private function __construct(
        public ?Datacenter $datacenter,
        public ?Error $error,
    ) {
        //
    }

    /**
     * @param  GetDatacenterResponseSchema  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            isset($attributes['datacenter']) ? Datacenter::from($attributes['datacenter']) : null,
            isset($attributes['error']) ? Error::from($attributes['error']) : null,
        );
    }

    #[Override]
    public function toArray(): array
    {
        return [
            'datacenter' => $this->datacenter?->toArray(),
            'error' => $this->error?->toArray(),
        ];
    }
}
