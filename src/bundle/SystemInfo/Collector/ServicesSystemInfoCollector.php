<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Bundle\SystemInfo\SystemInfo\Collector;

use Ibexa\Bundle\SystemInfo\SystemInfo\Value\ServicesSystemInfo;
use Ibexa\SystemInfo\Service\ServiceProviderInterface;

/**
 * Collects information about the services used within the project.
 */
final readonly class ServicesSystemInfoCollector implements SystemInfoCollector
{
    public function __construct(private ServiceProviderInterface $serviceProvider)
    {
    }

    public function collect(): ServicesSystemInfo
    {
        return new ServicesSystemInfo(
            $this->serviceProvider->getServiceType('searchEngine'),
            $this->serviceProvider->getServiceType('httpCacheProxy'),
            $this->serviceProvider->getServiceType('persistenceCacheAdapter')
        );
    }
}
