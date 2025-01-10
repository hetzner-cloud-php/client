<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Servers;

use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;
use HetznerCloud\Types\ApiPagination;
use Override;

/** @phpstan-type GetServersResponseSchema array{
 *    meta: array{
 *        pagination: ApiPagination
 *    },
 *    servers: array<int, array{
 *      backup_window: string,
 *      created: string,
 *      datacenter: array{
 *        description: string,
 *        id: positive-int,
 *        location: array{
 *          city: string,
 *          country: string,
 *          description: string,
 *          id: positive-int,
 *          latitude: float,
 *          longitude: float,
 *          name: string,
 *          network_zone: string
 *        },
 *        name: string,
 *        server_types: array{
 *          available: array<int, int>,
 *          available_for_migration: array<int, int>,
 *          supported: array<int, int>
 *        }
 *      },
 *      id: positive-int,
 *      image: array{
 *        architecture: string,
 *        bound_to: null,
 *        created: string,
 *        created_from: array{
 *          id: positive-int,
 *          name: string
 *        },
 *        deleted: null,
 *        deprecated: string,
 *        description: string,
 *        disk_size: positive-int,
 *        id: positive-int,
 *        image_size: float,
 *        labels: array<string, string>,
 *        name: string,
 *        os_flavor: string,
 *        os_version: string,
 *        protection: array{
 *          delete: bool
 *        },
 *        rapid_deploy: bool,
 *        status: string,
 *        type: string
 *      },
 *      included_traffic: positive-int,
 *      ingoing_traffic: positive-int,
 *      iso: array{
 *        architecture: string,
 *        deprecation: array{
 *          announced: string,
 *          unavailable_after: string
 *        },
 *        description: string,
 *        id: positive-int,
 *        name: string,
 *        type: string
 *      },
 *      labels: array<string, string>,
 *      load_balancers: array<int, int>,
 *      locked: bool,
 *      name: string,
 *      outgoing_traffic: positive-int,
 *      placement_group: array{
 *        created: string,
 *        id: positive-int,
 *        labels: array<string, string>,
 *        name: string,
 *        servers: array<int, int>,
 *        type: string
 *      },
 *      primary_disk_size: positive-int,
 *      private_net: array<int, array{
 *        alias_ips: array<int, string>,
 *        ip: string,
 *        mac_address: string,
 *        network: positive-int
 *      }>,
 *      protection: array{
 *        delete: bool,
 *        rebuild: bool
 *      },
 *      public_net: array{
 *        firewalls: array<int, array{
 *          id: positive-int,
 *          status: string
 *        }>,
 *        floating_ips: array<int, int>,
 *        ipv4: array{
 *          blocked: bool,
 *          dns_ptr: string,
 *          id: positive-int,
 *          ip: string
 *        },
 *        ipv6: array{
 *          blocked: bool,
 *          dns_ptr: array<int, array{
 *            dns_ptr: string,
 *            ip: string
 *          }>,
 *          id: positive-int,
 *          ip: string
 *        }
 *      },
 *      rescue_enabled: bool,
 *      server_type: array{
 *        architecture: string,
 *        cores: positive-int,
 *        cpu_type: string,
 *        deprecated: bool,
 *        deprecation: array{
 *          announced: string,
 *          unavailable_after: string
 *        },
 *        description: string,
 *        disk: positive-int,
 *        id: positive-int,
 *        memory: positive-int,
 *        name: string,
 *        prices: array<int, array{
 *          included_traffic: positive-int,
 *          location: string,
 *          price_hourly: array{
 *            gross: string,
 *            net: string
 *          },
 *          price_monthly: array{
 *            gross: string,
 *            net: string
 *          },
 *          price_per_tb_traffic: array{
 *            gross: string,
 *            net: string
 *          }
 *        }>,
 *        storage_type: string
 *      },
 *      status: string,
 *      volumes: array<int, int>
 *    }>
 *  }
 *
 * @implements ResponseContract<GetServersResponseSchema>
 */
final readonly class GetServersResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<GetServersResponseSchema>
     */
    use ArrayAccessible;

    /**
     * @param  GetServersResponseSchema['meta']  $meta
     * @param  GetServersResponseSchema['servers']  $servers
     */
    private function __construct(
        public array $meta,
        public array $servers,
    ) {
        //
    }

    /**
     * @param  GetServersResponseSchema  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            $attributes['meta'],
            $attributes['servers'],
        );
    }

    /**
     * {@inheritDoc}
     */
    #[Override]
    public function toArray(): array
    {
        return [
            'meta' => $this->meta,
            'servers' => $this->servers,
        ];
    }
}
