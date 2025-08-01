<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\SystemInfo\Service;

use Ibexa\Contracts\Core\SiteAccess\ConfigResolverInterface;

/**
 * @internal
 */
final readonly class PersistenceCacheServiceInfo implements ServiceInfo
{
    private const string PERSISTENCE_CACHE_CONFIG_KEY = 'cache_service_name';

    public function __construct(
        private ConfigResolverInterface $configResolver
    ) {
    }

    public function getServiceType(): string
    {
        return $this->configResolver->getParameter(
            self::PERSISTENCE_CACHE_CONFIG_KEY
        );
    }
}
