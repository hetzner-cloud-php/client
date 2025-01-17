<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Servers\Models;

use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;

/**
 * @phpstan-import-type DeprecationSchema from Deprecation
 *
 * @phpstan-type PriceSchema array{
 *     included_traffic: int,
 *     location: string,
 *     price_hourly: array{
 *       gross: string,
 *       net: string
 *     },
 *     price_monthly: array{
 *       gross: string,
 *       net: string
 *     },
 *     price_per_tb_traffic: array{
 *       gross: string,
 *       net: string
 *     }
 * }
 *
 * @implements ResponseContract<PriceSchema>
 */
final readonly class Price implements ResponseContract
{
    /**
     * @use ArrayAccessible<PriceSchema>
     */
    use ArrayAccessible;

    /**
     * @param  array{gross: string, net: string}  $priceHourly
     * @param  array{gross: string, net: string}  $priceMonthly
     * @param  array{gross: string, net: string}  $pricePerTbTraffic
     */
    public function __construct(
        public int $includedTraffic,
        public string $location,
        public array $priceHourly,
        public array $priceMonthly,
        public array $pricePerTbTraffic,
    ) {}

    /**
     * @param  PriceSchema  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            $attributes['included_traffic'],
            $attributes['location'],
            $attributes['price_hourly'],
            $attributes['price_monthly'],
            $attributes['price_per_tb_traffic'],
        );
    }

    public function toArray(): array
    {
        return [
            'included_traffic' => $this->includedTraffic,
            'location' => $this->location,
            'price_hourly' => $this->priceHourly,
            'price_monthly' => $this->priceMonthly,
            'price_per_tb_traffic' => $this->pricePerTbTraffic,
        ];
    }
}
