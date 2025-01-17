<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Servers\Models;

use Carbon\CarbonImmutable;
use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;

/**
 * @phpstan-import-type DeprecationSchema from Deprecation
 * @phpstan-import-type DatacenterSchema from Datacenter
 * @phpstan-import-type PlacementGroupSchema from PlacementGroup
 * @phpstan-import-type PrivateNetSchema from PrivateNet
 * @phpstan-import-type PublicNetSchema from PublicNet
 * @phpstan-import-type ProtectionSchema from Protection
 * @phpstan-import-type ServerImageSchema from ServerImage
 * @phpstan-import-type ServerIsoSchema from ServerIso
 * @phpstan-import-type ServerTypeSchema from ServerType
 *
 * @phpstan-type ServerSchema array{
 *     backup_window: ?string,
 *     created: string,
 *     datacenter: DatacenterSchema,
 *     id: int,
 *     image: ?ServerImageSchema,
 *     included_traffic: ?int,
 *     ingoing_traffic: ?int,
 *     iso: ?ServerIsoSchema,
 *     labels: array<string, string>,
 *     load_balancers?: array<int, int>,
 *     locked: bool,
 *     name: string,
 *     outgoing_traffic: int,
 *     placement_group?: ?PlacementGroupSchema,
 *     primary_disk_size: int,
 *     private_net: PrivateNetSchema[],
 *     protection: ProtectionSchema,
 *     public_net: PublicNetSchema,
 *     rescue_enabled: bool,
 *     server_type: ServerTypeSchema,
 *     status: string,
 *     volumes?: array<int, int>
 * }
 *
 * @implements ResponseContract<ServerSchema>
 */
final readonly class Server implements ResponseContract
{
    /**
     * @use ArrayAccessible<ServerSchema>
     */
    use ArrayAccessible;

    /**
     * @param  array<string, string>  $labels
     * @param  array<int, int>  $loadBalancers
     * @param  PrivateNetSchema[]  $privateNet
     * @param  array<int, int>  $volumes
     */
    public function __construct(
        public ?string $backupWindow,
        public CarbonImmutable $created,
        public Datacenter $datacenter,
        public int $id,
        public ?ServerImage $image,
        public ?int $includedTraffic,
        public ?int $ingoingTraffic,
        public ?ServerIso $iso,
        public array $labels,
        public array $loadBalancers,
        public bool $locked,
        public string $name,
        public int $outgoingTraffic,
        public ?PlacementGroup $placementGroup,
        public int $primaryDiskSize,
        public array $privateNet,
        public Protection $protection,
        public PublicNet $publicNet,
        public bool $rescueEnabled,
        public ServerType $serverType,
        public string $status,
        public array $volumes,
    ) {}

    /**
     * @param  ServerSchema  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            $attributes['backup_window'] ?? null,
            CarbonImmutable::parse($attributes['created']),
            Datacenter::from($attributes['datacenter']),
            $attributes['id'],
            isset($attributes['image']) ? ServerImage::from($attributes['image']) : null,
            $attributes['included_traffic'] ?? null,
            $attributes['ingoing_traffic'] ?? null,
            isset($attributes['iso']) ? ServerIso::from($attributes['iso']) : null,
            $attributes['labels'],
            $attributes['load_balancers'] ?? [],
            $attributes['locked'],
            $attributes['name'],
            $attributes['outgoing_traffic'],
            isset($attributes['placement_group']) ? PlacementGroup::from($attributes['placement_group']) : null,
            $attributes['primary_disk_size'],
            $attributes['private_net'],
            Protection::from($attributes['protection']),
            PublicNet::from($attributes['public_net']),
            $attributes['rescue_enabled'],
            ServerType::from($attributes['server_type']),
            $attributes['status'],
            $attributes['volumes'] ?? [],
        );
    }

    /**
     * @return ServerSchema
     */
    public function toArray(): array
    {
        return [
            'backup_window' => $this->backupWindow,
            'created' => $this->created->toIso8601String(),
            'status' => $this->status,
            'datacenter' => $this->datacenter->toArray(),
            'id' => $this->id,
            'image' => $this->image?->toArray(),
            'included_traffic' => $this->includedTraffic,
            'ingoing_traffic' => $this->ingoingTraffic,
            'iso' => $this->iso?->toArray(),
            'labels' => $this->labels,
            'load_balancers' => $this->loadBalancers,
            'locked' => $this->locked,
            'name' => $this->name,
            'outgoing_traffic' => $this->outgoingTraffic,
            'placement_group' => $this->placementGroup?->toArray(),
            'primary_disk_size' => $this->primaryDiskSize,
            'private_net' => $this->privateNet,
            'protection' => $this->protection->toArray(),
            'public_net' => $this->publicNet->toArray(),
            'rescue_enabled' => $this->rescueEnabled,
            'server_type' => $this->serverType->toArray(),
            'volumes' => $this->volumes,
        ];
    }
}
