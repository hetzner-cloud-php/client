<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Certificates;

use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;
use HetznerCloud\Responses\Certificates\Models\Certificate;
use HetznerCloud\Responses\Errors\ErrorResponse;

/**
 * @phpstan-import-type CertificateSchema from Certificate
 * @phpstan-import-type ErrorResponseSchema from ErrorResponse
 *
 * @phpstan-type GetCertificateResponseSchema array{
 *     certificate: ?CertificateSchema
 * }|ErrorResponseSchema
 *
 * @implements ResponseContract<GetCertificateResponseSchema>
 */
final readonly class GetCertificateResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<GetCertificateResponseSchema>
     */
    use ArrayAccessible;

    private function __construct(
        public ?Certificate $certificate,
        public ?ErrorResponse $error,
    ) {
        //
    }

    /**
     * @param  GetCertificateResponseSchema  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            isset($attributes['certificate']) ? Certificate::from($attributes['certificate']) : null,
            isset($attributes['error']) ? ErrorResponse::from($attributes['error']) : null,
        );
    }

    public function toArray(): array
    {
        return [
            'certificate' => $this->certificate?->toArray(),
            'error' => $this->error?->toArray(),
        ];
    }
}
