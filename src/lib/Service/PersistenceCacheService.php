<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\SystemInfo\Service;

use eZ\Publish\Core\MVC\ConfigResolverInterface;

/**
 * @internal
 */
final class PersistenceCacheService implements Service
{
    private const PERSISTENCE_CACHE_CONFIG_KEY = 'cache_service_name';

    /** @var \eZ\Publish\Core\MVC\ConfigResolverInterface */
    private $configResolver;

    public function __construct(ConfigResolverInterface $configResolver)
    {
        $this->configResolver = $configResolver;
    }

    public function getValue(): string
    {
        return $this->configResolver->getParameter(self::PERSISTENCE_CACHE_CONFIG_KEY);
    }
}
