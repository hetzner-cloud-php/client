<?php

declare(strict_types=1);

namespace HetznerCloud\Testing\Responses;

use HetznerCloud\Contracts\Resources\ActionsResourceContract;
use HetznerCloud\Resources\ActionsResource;
use HetznerCloud\Responses\Actions\GetActionResponse;
use HetznerCloud\Responses\Actions\GetActionsResponse;
use HetznerCloud\Testing\Resources\Concerns\Testable;

final class ActionsTestResource implements ActionsResourceContract
{
    use Testable;

    public function getActions(
        ?int $id = null,
        ?string $status = null,
        ?string $sort = null,
        int $page = 1,
        int $perPage = 25
    ): GetActionsResponse {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function getAction(int $id): GetActionResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function resource(): string
    {
        return ActionsResource::class;
    }
}
