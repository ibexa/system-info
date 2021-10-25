<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace Ibexa\Bundle\SystemInfo\SystemInfo\Value;

use eZ\Publish\API\Repository\Values\ValueObject;

/**
 * Invalid value for system info used in case of any errors occur while collecting data.
 */
final class InvalidSystemInfo extends ValueObject implements SystemInfo
{
    /**
     * Error message shown in the System info tab.
     *
     * @var string
     */
    public $errorMessage;
}

class_alias(InvalidSystemInfo::class, 'EzSystems\EzSupportToolsBundle\SystemInfo\Value\InvalidSystemInfo');
