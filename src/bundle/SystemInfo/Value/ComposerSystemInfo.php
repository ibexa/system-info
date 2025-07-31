<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Bundle\SystemInfo\SystemInfo\Value;

use Ibexa\Contracts\Core\Repository\Values\ValueObject;

/**
 * Value for information about installed Composer packages.
 */
final class ComposerSystemInfo extends ValueObject implements SystemInfo
{
    /** @var \Ibexa\Bundle\SystemInfo\SystemInfo\Value\ComposerPackage[]|null */
    public ?array $packages;

    /**
     * Minimum stability, as read from composer.lock.
     *
     * One of: stable, RC, beta, alpha, dev, or null if not set.
     */
    public ?string $minimumStability;

    /**
     * Additional Composer repository urls used.
     *
     * Will contain urls used so would be possible to know if bul or ttl packages are used for instance.
     *
     * @var string[]
     */
    public array $repositoryUrls = [];
}
