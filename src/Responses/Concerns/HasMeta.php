<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Concerns;

use HetznerCloud\Responses\Meta;

/**
 * @property-read Meta $meta
 */
trait HasMeta
{
    public function meta(): Meta
    {
        return $this->meta;
    }
}
