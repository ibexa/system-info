<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Bundle\SystemInfo\SystemInfo\Value;

use Ibexa\Contracts\Core\Repository\Values\ValueObject;

/**
 * Invalid value for system info used in case of any errors occur while collecting data.
 */
final class InvalidSystemInfo extends ValueObject implements SystemInfo
{
    public string $errorMessage;
}
