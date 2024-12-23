<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace Ibexa\Bundle\SystemInfo\SystemInfo\Exception;

use Exception;

final class ComposerFileValidationException extends Exception implements SystemInfoException
{
    public function __construct(string $path, int $code = 0, Exception $previous = null)
    {
        $message = sprintf('Composer file %s is not valid.', $path);

        parent::__construct($message, $code, $previous);
    }
}

class_alias(ComposerFileValidationException::class, 'EzSystems\EzSupportToolsBundle\SystemInfo\Exception\ComposerFileValidationException');
