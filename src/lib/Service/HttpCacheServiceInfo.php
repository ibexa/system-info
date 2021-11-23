<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\SystemInfo\Service;

/**
 * @internal
 */
final class HttpCacheServiceInfo implements ServiceInfo
{
    private string $purgeType;

    public function __construct(string $purgeType)
    {
        $this->purgeType = $purgeType;
    }

    public function getServiceType(): string
    {
        return $this->purgeType;
    }
}
