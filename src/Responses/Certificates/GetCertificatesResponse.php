<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Certificates;

use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;
use HetznerCloud\Responses\Certificates\Models\Certificate;
use HetznerCloud\Responses\Meta;

/**
 * @phpstan-import-type CertificateSchema from Certificate
 * @phpstan-import-type MetaSchema from Meta
 *
 * @phpstan-type GetCertificatesResponseSchema array{
 *     meta: MetaSchema,
 *     certificates: CertificateSchema[]
 * }
 *
 * @implements ResponseContract<GetCertificatesResponseSchema>
 */
final readonly class GetCertificatesResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<GetCertificatesResponseSchema>
     */
    use ArrayAccessible;

    /**
     * @param  Certificate[]  $certificates
     */
    private function __construct(
        public array $certificates,
        public Meta $meta,
    ) {
        //
    }

    /**
     * @param  GetCertificatesResponseSchema  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            array_map(fn (array $certificate): Certificate => Certificate::from($certificate), $attributes['certificates']),
            Meta::from($attributes['meta']),
        );
    }

    public function toArray(): array
    {
        return [
            'certificates' => array_map(
                static fn (Certificate $certificate): array => $certificate->toArray(),
                $this->certificates
            ),
            'meta' => $this->meta->toArray(),
        ];
    }
}
