<?php

declare(strict_types=1);

namespace HetznerCloud\Contracts;

interface HetznerResourceContract
{
    /**
     * @return class-string
     */
    public function resource(): string;
}
