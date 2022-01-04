<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\SystemInfo\Storage;

/**
 * @internal
 */
interface MetricsProvider
{
    public function provideMetrics(string $identifier): Metrics;
}

class_alias(MetricsProvider::class, 'EzSystems\EzSupportTools\Storage\MetricsProvider');
