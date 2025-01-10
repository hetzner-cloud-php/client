<?php

declare(strict_types=1);

namespace Tests;

use HetznerCloud\Contracts\ResponseContract;

arch('All source files are strictly typed')
    ->expect('HetznerCloud\\')
    ->toUseStrictTypes();

arch('All tests files are strictly typed')
    ->expect('Tests\\')
    ->toUseStrictTypes();

arch('Value objects should be immutable')
    ->expect('HetznerCloud\\ValueObjects\\')
    ->toBeFinal()
    ->and('HetznerCloud\\ValueObjects\\')
    ->toBeReadonly();

arch('Responses should be immutable and implement response contracts')
    ->expect('HetznerCloud\\Responses\\')
    ->classes()
    ->toBeFinal()
    ->and('HetznerCloud\\Responses\\')
    ->classes()
    ->toBeReadonly()
    ->and('HetznerCloud\\Responses\\')
    ->classes()
    ->toImplement(ResponseContract::class);

arch('Resources should be immutable')
    ->expect('HetznerCloud\\Resources\\')
    ->classes()
    ->toBeFinal()
    ->toBeReadonly();

arch('Contracts should be abstract')
    ->expect('HetznerCloud\\Contracts\\')
    ->toBeInterfaces();

arch('All Enums are backed')
    ->expect('HetznerCloud\\Enums\\')
    ->toBeStringBackedEnums();
