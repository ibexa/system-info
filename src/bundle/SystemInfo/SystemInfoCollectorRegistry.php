<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace Ibexa\Bundle\SystemInfo\SystemInfo;

use Ibexa\Bundle\SystemInfo\SystemInfo\Collector\SystemInfoCollector;

/**
 * A registry of SystemInfoCollectors.
 */
interface SystemInfoCollectorRegistry
{
    /**
     * @param \Ibexa\Bundle\SystemInfo\SystemInfo\Collector\SystemInfoCollector[] $items Hash of SystemInfoCollectors, with identifier string as key.
     */
    public function __construct(array $items = []);

    public function getItem(string $identifier): SystemInfoCollector;

    /**
     * @return string[] List of system info identifiers.
     */
    public function getIdentifiers(): array;
}
