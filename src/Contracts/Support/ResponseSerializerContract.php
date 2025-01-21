<?php

declare(strict_types=1);

namespace HetznerCloud\Contracts\Support;

use Psr\Http\Message\ResponseInterface;

interface ResponseSerializerContract
{
    /**
     * @template TModel
     *
     * @param  TModel  $model
     * @return array<array-key, mixed>
     */
    public function serialize(mixed $model): array;

    /**
     * @param  class-string  $to
     */
    public function deserialize(ResponseInterface $response, string $to): mixed;
}
