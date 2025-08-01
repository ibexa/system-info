<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\SystemInfo\Service;

/**
 * @internal
 */
final readonly class HttpCacheServiceInfo implements ServiceInfo
{
    public function __construct(private string $purgeType)
    {
    }

    public function getServiceType(): string
    {
        return $this->purgeType;
    }
}
