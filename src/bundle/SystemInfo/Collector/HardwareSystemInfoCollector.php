<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Bundle\SystemInfo\SystemInfo\Collector;

use Ibexa\Bundle\SystemInfo\SystemInfo\SystemInfoWrapper;
use Ibexa\Bundle\SystemInfo\SystemInfo\Value\HardwareSystemInfo;

/**
 * Collects hardware system information using zetacomponents/sysinfo.
 */
final readonly class HardwareSystemInfoCollector implements SystemInfoCollector
{
    public function __construct(private SystemInfoWrapper $systemInfoWrapper)
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
            'cpuType' => $this->systemInfoWrapper->cpuType,
            'cpuSpeed' => $this->systemInfoWrapper->cpuSpeed,
            'cpuCount' => $this->systemInfoWrapper->cpuCount,
            'memorySize' => $this->systemInfoWrapper->memorySize,
        ]);
    }
}
