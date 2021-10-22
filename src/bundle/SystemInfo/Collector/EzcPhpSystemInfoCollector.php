<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace Ibexa\Bundle\SystemInfo\SystemInfo\Collector;

use Ibexa\Bundle\SystemInfo\SystemInfo\EzcSystemInfoWrapper;
use Ibexa\Bundle\SystemInfo\SystemInfo\Value\PhpSystemInfo;

/**
 * Collects PHP information using zetacomponents/sysinfo.
 */
class EzcPhpSystemInfoCollector implements SystemInfoCollector
{
    /**
     * @var \EzSystems\EzSupportToolsBundle\SystemInfo\EzcSystemInfoWrapper
     */
    private $ezcSystemInfo;

    public function __construct(EzcSystemInfoWrapper $ezcSystemInfo)
    {
        $this->ezcSystemInfo = $ezcSystemInfo;
    }

    /**
     * Collects information about the PHP installation eZ Platform is using.
     *  - php version
     *  - php accelerator info.
     *
     * @return \EzSystems\EzSupportToolsBundle\SystemInfo\Value\PhpSystemInfo
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

class_alias(EzcPhpSystemInfoCollector::class, 'EzSystems\EzSupportToolsBundle\SystemInfo\Collector\EzcPhpSystemInfoCollector');
