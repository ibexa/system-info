<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Bundle\SystemInfo\SystemInfo\Collector;

use Ibexa\Bundle\SystemInfo\SystemInfo\SystemInfoWrapper;
use Ibexa\Bundle\SystemInfo\SystemInfo\Value\PhpSystemInfo;

/**
 * Collects PHP information using zetacomponents/sysinfo.
 */
final readonly class PhpSystemInfoCollector implements SystemInfoCollector
{
    public function __construct(private SystemInfoWrapper $wrapper)
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

        if ($this->wrapper->phpAccelerator) {
            $properties = array_merge(
                $properties,
                [
                    'acceleratorEnabled' => $this->wrapper->phpAccelerator->isEnabled,
                    'acceleratorName' => $this->wrapper->phpAccelerator->name,
                    'acceleratorURL' => $this->wrapper->phpAccelerator->url,
                    'acceleratorVersion' => $this->wrapper->phpAccelerator->versionString,
                ]
            );
        }

        return new PhpSystemInfo($properties);
    }
}
