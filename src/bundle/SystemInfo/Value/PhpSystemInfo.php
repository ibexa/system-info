<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Bundle\SystemInfo\SystemInfo\Value;

use Ibexa\Contracts\Core\Repository\Values\ValueObject;

/**
 * Value for information about the PHP interpreter and accelerator (if any) we are using.
 */
final class PhpSystemInfo extends ValueObject implements SystemInfo
{
    public string $version;

    public bool $acceleratorEnabled;

    public ?string $acceleratorName;

    /**
     * PHP accelerator URL, or null if no accelerator is enabled.
     *
     * Example: http://www.php.net/opcache
     */
    public ?string $acceleratorURL;

    /**
     * PHP accelerator version, or null if no accelerator is enabled.
     *
     * Example: 7.0.4-devFE
     */
    public ?string $acceleratorVersion;
}
