<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Datacenters;

use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;
use HetznerCloud\Responses\Concerns\HasMeta;
use HetznerCloud\Responses\Datacenters\Models\Datacenter;
use HetznerCloud\Responses\Meta;
use Override;

/**
 * @phpstan-import-type DatacenterSchema from Datacenter
 * @phpstan-import-type MetaSchema from Meta
 *
 * @phpstan-type GetDatacentersResponseSchema array{
 *     datacenters: DatacenterSchema[],
 *     meta: MetaSchema,
 *     recommendation: int,
 * }
 *
 * @implements ResponseContract<GetDatacentersResponseSchema>
 */
final readonly class GetDatacentersResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<GetDatacentersResponseSchema>
     */
    use ArrayAccessible;

    use HasMeta;

    /**
     * @param  Datacenter[]  $datacenters
     */
    private function __construct(
        public array $datacenters,
        public Meta $meta,
        public int $recommendation
    ) {
        //
    }

    /**
     * @param  GetDatacentersResponseSchema  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            array_map(
                static fn (array $datacenter): Models\Datacenter => Datacenter::from($datacenter),
                $attributes['datacenters']
            ),
            Meta::from($attributes['meta']),
            $attributes['recommendation']
        );
    }

    #[Override]
    public function toArray(): array
    {
        return [
            'datacenters' => array_map(
                static fn (Datacenter $datacenter): array => $datacenter->toArray(),
                $this->datacenters
            ),
            'meta' => $this->meta->toArray(),
            'recommendation' => $this->recommendation,
        ];
    }
}
