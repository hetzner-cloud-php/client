<?php

declare(strict_types=1);

namespace HetznerCloud\Contracts\Resources;

use HetznerCloud\Responses\Actions\GetActionResponse;
use HetznerCloud\Responses\Actions\GetActionsResponse;

interface ActionsResourceContract
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
