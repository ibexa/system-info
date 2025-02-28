<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\SystemInfo\Storage;

use Ibexa\Bundle\SystemInfo\SystemInfo\Exception\MetricsNotFoundException;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\DependencyInjection\ServiceLocator;

/**
 * @internal
 */
final readonly class AggregateMetricsProvider implements MetricsProvider
{
    /**
     * @param \Symfony\Component\DependencyInjection\ServiceLocator<\Ibexa\SystemInfo\Storage\Metrics> $metricsLocator
     */
    public function __construct(private ServiceLocator $metricsLocator)
    {
    }

    public function provideMetrics(string $identifier): Metrics
    {
        try {
            return $this->metricsLocator->get($identifier);
        } catch (ServiceNotFoundException $e) {
            throw new MetricsNotFoundException($identifier, $e);
        }
    }
}
