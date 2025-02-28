<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace Ibexa\Bundle\SystemInfo\SystemInfo\Collector;

use Ibexa\Bundle\SystemInfo\SystemInfo\EzcSystemInfoWrapper;
use Ibexa\Bundle\SystemInfo\SystemInfo\Value\HardwareSystemInfo;

/**
 * Collects hardware system information using zetacomponents/sysinfo.
 */
readonly class EzcHardwareSystemInfoCollector implements SystemInfoCollector
{
    public function __construct(private EzcSystemInfoWrapper $ezcSystemInfo)
    {
    }

    /**
     * Collects information about the hardware Ibexa DXP is installed on.
     *  - cpu information
     *  - memory size.
     */
    public function collect(): HardwareSystemInfo
    {
        return new HardwareSystemInfo([
            'cpuType' => $this->ezcSystemInfo->cpuType,
            'cpuSpeed' => $this->ezcSystemInfo->cpuSpeed,
            'cpuCount' => $this->ezcSystemInfo->cpuCount,
            'memorySize' => $this->ezcSystemInfo->memorySize,
        ]);
    }
}
