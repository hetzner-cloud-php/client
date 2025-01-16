<?php

declare(strict_types=1);

namespace HetznerCloud\Resources;

use HetznerCloud\Contracts\Resources\ActionsResourceContract;
use HetznerCloud\HttpClientUtilities\Contracts\ConnectorContract;
use HetznerCloud\HttpClientUtilities\Support\ClientRequestBuilder;
use HetznerCloud\HttpClientUtilities\ValueObjects\Response;
use HetznerCloud\Responses\Actions\GetActionsResponse;
use Rector\Exception\NotImplementedYetException;

/**
 * @phpstan-import-type GetActionsResponseSchema from GetActionsResponse
 */
final readonly class ActionsResource implements ActionsResourceContract
{
    public function __construct(
        public ConnectorContract $connector
    ) {
        //
    }

    public function getActions(
        ?int $id = null,
        ?string $status = null,
        ?string $sort = null,
        int $page = 1,
        int $perPage = 25
    ): GetActionsResponse {
        $request = ClientRequestBuilder::get('actions')
            ->withQueryParams([
                'page' => $page,
                'per_page' => $perPage,
                'sort' => $sort,
            ]);

        /** @var Response<array<array-key, mixed>> $response */
        $response = $this->connector->sendClientRequest($request);

        /** @var GetActionsResponseSchema $data */
        $data = $response->data();

        return GetActionsResponse::from($data);
    }

    public function getAction(int $id): GetActionsResponse
    {
        throw new NotImplementedYetException;
    }
}
