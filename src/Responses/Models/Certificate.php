<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Models;

use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;
use HetznerCloud\Responses\Errors\Error;

/**
 * @phpstan-import-type CertificateStatusSchema from CertificateStatus
 * @phpstan-import-type ErrorSchema from Error
 *
 * @phpstan-type CertificateSchema array{
 *     certificate: string,
 *     created: string,
 *     domain_names: string[],
 *     fingerprint: ?string,
 *     id: int,
 *     labels: array<string, string>,
 *     name: string,
 *     not_valid_after: ?string,
 *     not_valid_before: ?string,
 *     status: ?CertificateStatusSchema,
 *     type?: string,
 *     used_by: array<int, array{
 *         id: int,
 *         type: string
 *     }>,
 * }
 *
 * @implements ResponseContract<CertificateSchema>
 */
final readonly class Certificate implements ResponseContract
{
    /**
     * @use ArrayAccessible<CertificateSchema>
     */
    use ArrayAccessible;

    /**
     * @param  string[]  $domainNames
     * @param  array<string, string>  $labels
     * @param  array<int, array{id: int, type: string}>  $usedBy
     */
    private function __construct(
        public string $certificate,
        public string $created,
        public array $domainNames,
        public ?string $fingerprint,
        public int $id,
        public array $labels,
        public string $name,
        public ?string $notValidAfter,
        public ?string $notValidBefore,
        public ?CertificateStatus $status,
        public array $usedBy,
    ) {
        //
    }

    /**
     * @param  CertificateSchema  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            $attributes['certificate'],
            $attributes['created'],
            $attributes['domain_names'],
            $attributes['fingerprint'] ?? null,
            $attributes['id'],
            $attributes['labels'],
            $attributes['name'],
            $attributes['not_valid_after'] ?? null,
            $attributes['not_valid_before'] ?? null,
            isset($attributes['status']) ? CertificateStatus::from($attributes['status']) : null,
            $attributes['used_by'],
        );
    }

    public function toArray(): array
    {
        return [
            'certificate' => $this->certificate,
            'created' => $this->created,
            'domain_names' => $this->domainNames,
            'fingerprint' => $this->fingerprint,
            'id' => $this->id,
            'labels' => $this->labels,
            'name' => $this->name,
            'not_valid_after' => $this->notValidAfter,
            'not_valid_before' => $this->notValidBefore,
            'status' => $this->status?->toArray(),
            'used_by' => $this->usedBy,
        ];
    }
}
