<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Bundle\SystemInfo;

use Ibexa\Bundle\SystemInfo\DependencyInjection\Compiler\OutputFormatPass;
use Ibexa\Bundle\SystemInfo\DependencyInjection\Compiler\SystemInfoCollectorPass;
use Ibexa\Bundle\SystemInfo\DependencyInjection\Compiler\SystemInfoTabGroupPass;
use Ibexa\Bundle\SystemInfo\DependencyInjection\IbexaSystemInfoExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class IbexaSystemInfoBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new SystemInfoCollectorPass());
        $container->addCompilerPass(new OutputFormatPass());
        $container->addCompilerPass(new SystemInfoTabGroupPass());
    }

    public function getContainerExtension(): ExtensionInterface
    {
        return new IbexaSystemInfoExtension();
    }
}
