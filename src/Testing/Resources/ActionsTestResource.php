<?php

declare(strict_types=1);

namespace HetznerCloud\Testing\Resources;

use HetznerCloud\Contracts\Resources\ActionsResourceContract;
use HetznerCloud\Resources\ActionsResource;
use HetznerCloud\Responses\Actions\GetActionResponse;
use HetznerCloud\Responses\Actions\GetActionsResponse;
use HetznerCloud\Testing\Resources\Concerns\Testable;

/**
 * @phpstan-import-type GetActionsResponseSchema from GetActionsResponse
 * @phpstan-import-type GetActionResponseSchema from GetActionResponse
 *
 * @phpstan-type ActionsResponseSchema GetActionsResponseSchema|GetActionResponseSchema
 */
final class ActionsTestResource implements ActionsResourceContract
{
    /**
     * @use Testable<ActionsResponseSchema>
     */
    use Testable;

    public function getActions(
        ?int $id = null,
        ?string $status = null,
        ?string $sort = null,
        int $page = 1,
        int $perPage = 25
    ): GetActionsResponse {
        /** @var GetActionsResponse $response */
        $response = $this->record(__FUNCTION__, func_get_args());

        return $response;
    }

    public function getAction(int $id): GetActionResponse
    {
        /** @var GetActionResponse $response */
        $response = $this->record(__FUNCTION__, func_get_args());

        return $response;
    }

    public function resource(): string
    {
        return ActionsResource::class;
    }
}
