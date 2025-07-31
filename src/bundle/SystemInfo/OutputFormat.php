<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Bundle\SystemInfo\SystemInfo;

interface OutputFormat
{
    /**
     * Format an array of collected information data, and return it as string.
     *
     * @param array<string, \Ibexa\Bundle\SystemInfo\SystemInfo\Value\SystemInfo> $collectedInfo
     */
    public function format(array $collectedInfo): string;
}
