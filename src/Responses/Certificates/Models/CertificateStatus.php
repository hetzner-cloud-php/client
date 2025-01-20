<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Certificates\Models;

use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;
use HetznerCloud\Responses\Errors\Error;

/**
 * @phpstan-import-type ErrorSchema from Error
 *
 * @phpstan-type CertificateStatusSchema array{
 *     error: ?ErrorSchema,
 *     issuance: string,
 *     renewal: string,
 * }
 *
 * @implements ResponseContract<CertificateStatusSchema>
 */
final readonly class CertificateStatus implements ResponseContract
{
    /**
     * @use ArrayAccessible<CertificateStatusSchema>
     */
    use ArrayAccessible;

    private function __construct(
        public ?Error $error,
        public string $issuance,
        public string $renewal,
    ) {
        //
    }

    /**
     * @param  CertificateStatusSchema  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            isset($attributes['error']) ? Error::from($attributes['error']) : null,
            $attributes['issuance'],
            $attributes['renewal'],
        );
    }

    public function toArray(): array
    {
        return [
            'error' => $this->error?->toArray(),
            'issuance' => $this->issuance,
            'renewal' => $this->renewal,
        ];
    }
}
