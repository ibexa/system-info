<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace Ibexa\Bundle\SystemInfo\SystemInfo\Exception;

use Exception;
use eZ\Publish\Core\Base\Exceptions\NotFoundException as BaseNotFoundException;

class SysInfoServiceNotFoundException extends BaseNotFoundException
{
    public function __construct(string $identifier, Exception $previous = null)
    {
        parent::__construct('Service', $identifier, $previous);
    }
}

class_alias(SysInfoServiceNotFoundException::class, 'EzSystems\EzSupportToolsBundle\SystemInfo\Exception\SysInfoServiceNotFoundException');
