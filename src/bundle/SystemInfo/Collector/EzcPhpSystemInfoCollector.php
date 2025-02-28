<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace Ibexa\Bundle\SystemInfo\SystemInfo\Collector;

use Ibexa\Bundle\SystemInfo\SystemInfo\EzcSystemInfoWrapper;
use Ibexa\Bundle\SystemInfo\SystemInfo\Value\PhpSystemInfo;

/**
 * Collects PHP information using zetacomponents/sysinfo.
 */
readonly class EzcPhpSystemInfoCollector implements SystemInfoCollector
{
    public function __construct(private EzcSystemInfoWrapper $ezcSystemInfo)
    {
    }

    /**
     * Collects information about the PHP installation Ibexa DXP is using.
     *  - php version
     *  - php accelerator info.
     */
    public function collect(): PhpSystemInfo
    {
        $properties = [
            'version' => PHP_VERSION,
            'acceleratorEnabled' => false,
        ];

        if ($this->ezcSystemInfo->phpAccelerator) {
            $properties = array_merge(
                $properties,
                [
                    'acceleratorEnabled' => $this->ezcSystemInfo->phpAccelerator->isEnabled,
                    'acceleratorName' => $this->ezcSystemInfo->phpAccelerator->name,
                    'acceleratorURL' => $this->ezcSystemInfo->phpAccelerator->url,
                    'acceleratorVersion' => $this->ezcSystemInfo->phpAccelerator->versionString,
                ]
            );
        }

        return new PhpSystemInfo($properties);
    }
}
