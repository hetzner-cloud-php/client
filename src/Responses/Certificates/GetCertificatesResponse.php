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
 * @phpstan-type GetCertificateResponseSchema array{
 *     meta: MetaSchema,
 *     certificates: CertificateSchema[]
 * }
 *
 * @implements ResponseContract<GetCertificateResponseSchema>
 */
final class GetCertificatesResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<GetCertificateResponseSchema>
     */
    use ArrayAccessible;

    /**
     * @param  Certificate[]  $certificate
     */
    private function __construct(
        public array $certificate,
        public Meta $meta,
    ) {
        //
    }

    /**
     * @param  GetCertificateResponseSchema  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            array_map(fn (array $certificate): \HetznerCloud\Responses\Certificates\Models\Certificate => Certificate::from($certificate), $attributes['certificates']),
            Meta::from($attributes['meta']),
        );
    }

    public function toArray(): array
    {
        return [
            'certificates' => array_map(
                static fn (Certificate $certificate): array => $certificate->toArray(),
                $this->certificate
            ),
            'meta' => $this->meta->toArray(),
        ];
    }
}
