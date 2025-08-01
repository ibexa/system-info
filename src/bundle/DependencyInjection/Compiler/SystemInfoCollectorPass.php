<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Bundle\SystemInfo\DependencyInjection\Compiler;

use Ibexa\Bundle\SystemInfo\SystemInfo\Registry\IdentifierBased;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final readonly class SystemInfoCollectorPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->has(IdentifierBased::class)) {
            return;
        }

        $infoCollectorsTagged = $container->findTaggedServiceIds('ibexa.system_info.collector');

        $infoCollectors = [];
        foreach ($infoCollectorsTagged as $id => $tags) {
            foreach ($tags as $attributes) {
                $infoCollectors[$attributes['identifier']] = new Reference($id);
            }
        }

        $infoCollectorRegistryDef = $container->findDefinition(IdentifierBased::class);
        $infoCollectorRegistryDef->setArguments([$infoCollectors]);
    }
}
