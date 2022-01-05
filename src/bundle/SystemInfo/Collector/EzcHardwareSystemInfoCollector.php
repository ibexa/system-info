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
class EzcHardwareSystemInfoCollector implements SystemInfoCollector
{
    /**
     * @var \Ibexa\Bundle\SystemInfo\SystemInfo\EzcSystemInfoWrapper
     */
    private $ezcSystemInfo;

    public function __construct(EzcSystemInfoWrapper $ezcSystemInfo)
    {
        $this->ezcSystemInfo = $ezcSystemInfo;
    }

    /**
     * Collects information about the hardware eZ Platform is installed on.
     *  - cpu information
     *  - memory size.
     *
     * @return \Ibexa\Bundle\SystemInfo\SystemInfo\Value\HardwareSystemInfo
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

class_alias(EzcHardwareSystemInfoCollector::class, 'EzSystems\EzSupportToolsBundle\SystemInfo\Collector\EzcHardwareSystemInfoCollector');
