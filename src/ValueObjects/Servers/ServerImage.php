<?php

declare(strict_types=1);

namespace HetznerCloud\ValueObjects\Servers;

use Carbon\CarbonImmutable;
use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;

/**
 * @phpstan-import-type CreatedFromSchema from CreatedFrom
 * @phpstan-import-type ProtectionSchema from Protection
 *
 * @phpstan-type ServerImageSchema array{
 *     architecture: string,
 *     bound_to?: ?string,
 *     created: string,
 *     created_from: CreatedFromSchema,
 *     deleted?: ?string,
 *     deprecated?: ?string,
 *     description: string,
 *     disk_size: int,
 *     id: int,
 *     image_size: float,
 *     labels: array<string, string>,
 *     name: string,
 *     os_flavor: string,
 *     os_version: string,
 *     protection: ProtectionSchema,
 *     rapid_deploy: bool,
 *     status: string,
 *     type: string
 * }
 *
 * @implements ResponseContract<ServerImageSchema>
 */
final readonly class ServerImage implements ResponseContract
{
    /**
     * @use ArrayAccessible<ServerImageSchema>
     */
    use ArrayAccessible;

    /**
     * @param  array<string, string>  $labels
     */
    public function __construct(
        public string $architecture,
        public ?string $boundTo,
        public CarbonImmutable $created,
        public CreatedFrom $createdFrom,
        public ?CarbonImmutable $deleted,
        public ?CarbonImmutable $deprecated,
        public string $description,
        public int $diskSize,
        public int $id,
        public float $imageSize,
        public array $labels,
        public string $name,
        public string $osFlavor,
        public string $osVersion,
        public Protection $protection,
        public bool $rapidDeploy,
        public string $status,
        public string $type,
    ) {}

    /**
     * @param  ServerImageSchema  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            $attributes['architecture'],
            $attributes['bound_to'] ?? null,
            new CarbonImmutable($attributes['created']),
            CreatedFrom::from($attributes['created_from']),
            isset($attributes['deleted']) ? new CarbonImmutable($attributes['deleted']) : null,
            isset($attributes['deprecated']) ? new CarbonImmutable($attributes['deprecated']) : null,
            $attributes['description'],
            $attributes['disk_size'],
            $attributes['id'],
            $attributes['image_size'],
            $attributes['labels'],
            $attributes['name'],
            $attributes['os_flavor'],
            $attributes['os_version'],
            Protection::from($attributes['protection']),
            $attributes['rapid_deploy'],
            $attributes['status'],
            $attributes['type']
        );
    }

    public function toArray(): array
    {
        return [
            'architecture' => $this->architecture,
            'bound_to' => $this->boundTo,
            'created' => $this->created->toIso8601String(),
            'created_from' => $this->createdFrom->toArray(),
            'deleted' => $this->deleted?->toIso8601String(),
            'deprecated' => $this->deprecated?->toIso8601String(),
            'description' => $this->description,
            'disk_size' => $this->diskSize,
            'id' => $this->id,
            'image_size' => $this->imageSize,
            'labels' => $this->labels,
            'name' => $this->name,
            'os_flavor' => $this->osFlavor,
            'os_version' => $this->osVersion,
            'protection' => $this->protection->toArray(),
            'rapid_deploy' => $this->rapidDeploy,
            'status' => $this->status,
            'type' => $this->type,
        ];
    }
}
