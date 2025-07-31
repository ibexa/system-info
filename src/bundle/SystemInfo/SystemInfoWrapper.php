<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Bundle\SystemInfo\SystemInfo;

use ezcSystemInfo;
use ezcSystemInfoAccelerator;
use ezcSystemInfoReaderCantScanOSException;

/**
 * This wraps zetacomponents/sysinfo, exposing its magic properties as public properties.
 * Used here to allow lazy loading.
 */
class SystemInfoWrapper
{
    public ?string $osType;

    public ?string $osName;

    public ?string $fileSystemType;

    public ?int $cpuCount;

    public ?string $cpuType;

    public ?float $cpuSpeed;

    public ?int $memorySize;

    public ?string $lineSeparator;

    public ?string $backupFileName;

    /** @var array<int, string>|null */
    public ?array $phpVersion;

    public ?ezcSystemInfoAccelerator $phpAccelerator;

    public ?bool $isShellExecution;

    public function __construct()
    {
        try {
            $ezcSystemInfo = ezcSystemInfo::getInstance();
        } catch (ezcSystemInfoReaderCantScanOSException $e) {
            // Leave properties as null: https://github.com/zetacomponents/SystemInformation/pull/9
            return;
        }

        foreach (array_keys(get_class_vars(self::class)) as $var) {
            $this->$var = $ezcSystemInfo->$var;
        }
    }
}
