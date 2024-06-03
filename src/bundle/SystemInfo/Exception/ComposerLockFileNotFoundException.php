<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace Ibexa\Bundle\SystemInfo\SystemInfo\Exception;

use Exception;
use Ibexa\Core\Base\Exceptions\NotFoundException as BaseNotFoundException;

class ComposerLockFileNotFoundException extends BaseNotFoundException implements SystemInfoException
{
    public function __construct($path, Exception $previous = null)
    {
        parent::__construct('composer.lock file', $path, $previous);
    }
}

class_alias(ComposerLockFileNotFoundException::class, 'EzSystems\EzSupportToolsBundle\SystemInfo\Exception\ComposerLockFileNotFoundException');
