<?php

declare(strict_types=1);

namespace HetznerCloud\Resources\Concerns;

trait SelfIdentifiedResource
{
    /**
     * @return class-string
     */
    public function resource(): string
    {
        return self::class;
    }
}
