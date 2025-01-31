<?php

declare(strict_types=1);

namespace HetznerCloud\Contracts\Resources;

use HetznerCloud\Responses\Resources\Actions\GetActionResponse;
use HetznerCloud\Responses\Resources\Actions\GetActionsResponse;

interface CertificateActionsResourceContract
{
    public function getActions(
        ?int $id = null,
        ?string $status = null,
        ?string $sort = null,
        int $page = 1,
        int $perPage = 25
    ): GetActionsResponse;

    public function getCertificateActions(
        int $id,
        ?string $status = null,
        ?string $sort = null,
        int $page = 1,
        int $perPage = 25
    ): GetActionsResponse;

    public function getAction(int $id): GetActionResponse;

    public function getCertificateAction(int $certificateId, int $actionId): GetActionResponse;

    public function retryIssuanceOrRenewal(int $id): GetActionResponse;
}
