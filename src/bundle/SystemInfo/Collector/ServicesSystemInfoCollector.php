<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace Ibexa\Bundle\SystemInfo\SystemInfo\Collector;

use Ibexa\SystemInfo\Service\ServiceProviderInterface;
use Ibexa\Bundle\SystemInfo\SystemInfo\Value\ServicesSystemInfo;

/**
 * Collects information about the services used within the project.
 */
final class ServicesSystemInfoCollector implements SystemInfoCollector
{
    /** @var \Ibexa\SystemInfo\Service\ServiceProviderInterface */
    private $serviceProvider;

    public function __construct(ServiceProviderInterface $serviceProvider)
    {
        $this->serviceProvider = $serviceProvider;
    }

    public function collect(): ServicesSystemInfo
    {
        return new ServicesSystemInfo([
            'searchEngine' => $this->serviceProvider->provide('searchEngine')->getValue(),
            'httpCacheProxy' => $this->serviceProvider->provide('httpCacheProxy')->getValue(),
            'persistenceCacheAdapter' => $this->serviceProvider->provide('persistenceCacheAdapter')->getValue(),
        ]);
    }
}

class_alias(ServicesSystemInfoCollector::class, 'EzSystems\EzSupportToolsBundle\SystemInfo\Collector\ServicesSystemInfoCollector');
