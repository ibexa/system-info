<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

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

    /**
     * Returns the SystemInfoCollector matching the argument.
     *
     * @throws \Ibexa\Core\Base\Exceptions\NotFoundException If no SystemInfoCollector exists with this identifier
     */
    public function getItem(string $identifier): SystemInfoCollector;

    /**
     * @return string[]
     */
    public function getIdentifiers(): array;
}
