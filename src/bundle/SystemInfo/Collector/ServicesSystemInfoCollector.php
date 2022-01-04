<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace Ibexa\Bundle\SystemInfo\SystemInfo\Collector;

use Ibexa\Bundle\SystemInfo\SystemInfo\Value\ServicesSystemInfo;
use Ibexa\SystemInfo\Service\ServiceProviderInterface;

/**
 * Collects information about the services used within the project.
 */
final class ServicesSystemInfoCollector implements SystemInfoCollector
{
    private ServiceProviderInterface $serviceProvider;

    public function __construct(ServiceProviderInterface $serviceProvider)
    {
        $this->serviceProvider = $serviceProvider;
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
