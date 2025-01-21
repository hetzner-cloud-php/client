<?php

declare(strict_types=1);

namespace HetznerCloud\Support;

use Crell\Serde\SerdeCommon;
use HetznerCloud\Contracts\Support\ResponseSerializerContract;
use HetznerCloud\Exceptions\NotImplementedException;
use Psr\Http\Message\ResponseInterface;

final class JsonResponseSerializer implements ResponseSerializerContract
{
    public private(set) SerdeCommon $serializer;

    public function __construct()
    {
        $this->serializer = new SerdeCommon();
    }

    public function serialize(mixed $model): array
    {
        throw new NotImplementedException;
    }

    /**
     * @param class-string $to
     */
    public function deserialize(ResponseInterface $response, string $to): mixed
    {
        $content = $response->getBody()->getContents();

        return $this->serializer->deserialize($content, 'json', $to);
    }
}
