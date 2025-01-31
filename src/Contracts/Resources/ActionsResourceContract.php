<?php

declare(strict_types=1);

namespace HetznerCloud\Contracts\Resources;

use HetznerCloud\Contracts\HetznerResourceContract;
use HetznerCloud\Responses\Resources\Actions\GetActionResponse;
use HetznerCloud\Responses\Resources\Actions\GetActionsResponse;

interface ActionsResourceContract extends HetznerResourceContract
{
    public function getActions(
        ?int $id = null,
        ?string $status = null,
        ?string $sort = null,
        int $page = 1,
        int $perPage = 25
    ): GetActionsResponse;

    public function getAction(int $id): GetActionResponse;
}
