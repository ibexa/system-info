<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace Ibexa\Bundle\SystemInfo\SystemInfo\OutputFormat;

use Ibexa\Bundle\SystemInfo\SystemInfo\OutputFormat as SystemInfoOutputFormat;

/**
 * Implements the JSON output format.
 */
class JsonOutputFormat implements SystemInfoOutputFormat
{
    public function format(array $collectedInfo)
    {
        return json_encode($collectedInfo, JSON_PRETTY_PRINT);
    }
}

class_alias(JsonOutputFormat::class, 'EzSystems\EzSupportToolsBundle\SystemInfo\OutputFormat\JsonOutputFormat');
