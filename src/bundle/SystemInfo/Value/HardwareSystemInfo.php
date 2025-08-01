<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Bundle\SystemInfo\SystemInfo\Value;

use Ibexa\Contracts\Core\Repository\Values\ValueObject;

/**
 * Value for information about the hardware we are running on.
 */
final class HardwareSystemInfo extends ValueObject implements SystemInfo
{
    public ?string $cpuType;

    public ?string $cpuSpeed;

    public ?int $cpuCount;

    public ?float $memorySize;
}
