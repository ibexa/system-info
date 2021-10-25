<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace Ibexa\Bundle\SystemInfo\SystemInfo\Collector;

use Ibexa\Bundle\SystemInfo\SystemInfo\Value;

/**
 * Collects system information.
 */
interface SystemInfoCollector
{
    /**
     * Collects system information.
     *
     * @return Value\SystemInfo
     */
    public function collect();
}

class_alias(SystemInfoCollector::class, 'EzSystems\EzSupportToolsBundle\SystemInfo\Collector\SystemInfoCollector');
