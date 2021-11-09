<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\SystemInfo\Service;

use Ibexa\Bundle\SystemInfo\SystemInfo\Exception\SysInfoServiceNotFoundException;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\DependencyInjection\ServiceLocator;

/**
 * @internal
 */
final class AggregateServiceProvider implements ServiceProviderInterface
{
    /** @var \Symfony\Component\DependencyInjection\ServiceLocator */
    private $serviceLocator;

    public function __construct(ServiceLocator $service)
    {
        $this->serviceLocator = $service;
    }

    /**
     * @throws \Ibexa\Bundle\SystemInfo\SystemInfo\Exception\SysInfoServiceNotFoundException
     */
    public function provide(string $identifier): Service
    {
        try {
            return $this->serviceLocator->get($identifier);
        } catch (ServiceNotFoundException $e) {
            throw new SysInfoServiceNotFoundException($identifier, $e);
        }
    }
}
