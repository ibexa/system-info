<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\SystemInfo\Service;

/**
 * @internal
 */
interface ServiceProviderInterface
{
    public function provide(string $identifier): Service;
}

class_alias(ServiceProviderInterface::class, 'EzSystems\EzSupportTools\Service\ServiceProviderInterface');
