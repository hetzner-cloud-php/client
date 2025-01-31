<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Resources\Certificates;

use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;
use HetznerCloud\Responses\Errors\Error;
use HetznerCloud\Responses\Errors\ErrorResponse;
use HetznerCloud\Responses\Models\Action;
use HetznerCloud\Responses\Models\Certificate;
use Override;

/**
 * @phpstan-import-type ActionSchema from Action
 * @phpstan-import-type CertificateSchema from Certificate
 * @phpstan-import-type ErrorResponseSchema from ErrorResponse
 *
 * @phpstan-type CreateCertificateResponseSchema array{
 *     certificate?: CertificateSchema,
 *     action?: ActionSchema
 * }|ErrorResponseSchema
 *
 * @implements ResponseContract<CreateCertificateResponseSchema>
 */
final readonly class CreateCertificateResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<CreateCertificateResponseSchema>
     */
    use ArrayAccessible;

    private function __construct(
        public ?Certificate $certificate,
        public ?Action $action,
        public ?Error $error,
    ) {
        //
    }

    /**
     * @param  CreateCertificateResponseSchema  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            isset($attributes['certificate']) ? Certificate::from($attributes['certificate']) : null,
            isset($attributes['action']) ? Action::from($attributes['action']) : null,
            isset($attributes['error']) ? Error::from($attributes['error']) : null,
        );
    }

    #[Override]
    public function toArray(): array
    {
        return [
            'certificate' => $this->certificate?->toArray(),
            'action' => $this->action?->toArray(),
            'error' => $this->error?->toArray(),
        ];
    }
}
