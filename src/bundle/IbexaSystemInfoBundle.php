<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace Ibexa\Bundle\SystemInfo;

use Ibexa\Bundle\SystemInfo\DependencyInjection\Compiler\OutputFormatPass;
use Ibexa\Bundle\SystemInfo\DependencyInjection\Compiler\SystemInfoCollectorPass;
use Ibexa\Bundle\SystemInfo\DependencyInjection\Compiler\SystemInfoTabGroupPass;
use Ibexa\Bundle\SystemInfo\DependencyInjection\IbexaSystemInfoExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class IbexaSystemInfoBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new SystemInfoCollectorPass());
        $container->addCompilerPass(new OutputFormatPass());
        $container->addCompilerPass(new SystemInfoTabGroupPass());
    }

    /**
     * {@inheritdoc}
     */
    public function getContainerExtension(): ExtensionInterface
    {
        return new IbexaSystemInfoExtension();
    }
}

class_alias(IbexaSystemInfoBundle::class, 'EzSystems\EzSupportToolsBundle\EzSystemsEzSupportToolsBundle');
