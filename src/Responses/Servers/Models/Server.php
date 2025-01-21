<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Servers\Models;

use Crell\Serde\Attributes as Serde;
use Crell\Serde\Renaming\Cases;
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
 *     volumes?: int[]
 * }
 *
 * @implements ResponseContract<ServerSchema>
 */
#[Serde\ClassSettings(renameWith: Cases::snake_case)]
final class Server implements ResponseContract
{
    /**
     * @use ArrayAccessible<ServerSchema>
     */
    use ArrayAccessible;

    public ?string $backupWindow;

    public string $created;

    public Datacenter $datacenter;

    public int $id;

    public ?ServerImage $image;

    public ?int $includedTraffic;

    public ?int $ingoingTraffic;

    public ?ServerIso $iso;

    /** @var array<string, string> */
    public array $labels;

    /** @var array<int, int> */
    public array $loadBalancers;

    public bool $locked;

    public string $name;

    public int $outgoingTraffic;

    public ?PlacementGroup $placementGroup;

    public int $primaryDiskSize;

    /** @var PrivateNet[] */
    public array $privateNet;

    public Protection $protection;

    public PublicNet $publicNet;

    public bool $rescueEnabled;

    public ServerType $serverType;

    public string $status;

    /** @var int[] */
    public array $volumes;

    /**
     * @return ServerSchema
     */
    public function toArray(): array
    {
        return [
            'backup_window' => $this->backupWindow,
            'created' => $this->created,
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
