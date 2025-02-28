<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\SystemInfo\Service;

use Ibexa\Bundle\SystemInfo\SystemInfo\Exception\SystemInfoServiceNotFoundException;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\DependencyInjection\ServiceLocator;

/**
 * @internal
 */
final readonly class AggregateServiceProvider implements ServiceProviderInterface
{
    /**
     * @param ServiceLocator<ServiceProviderInterface> $serviceLocator
     */
    public function __construct(private ServiceLocator $serviceLocator)
    {
    }

    public function getServiceType(string $identifier): string
    {
        try {
            $service = $this->serviceLocator->get($identifier);

            return $service->getServiceType($identifier);
        } catch (ServiceNotFoundException $e) {
            throw new SystemInfoServiceNotFoundException($identifier, $e);
        }
    }
}
