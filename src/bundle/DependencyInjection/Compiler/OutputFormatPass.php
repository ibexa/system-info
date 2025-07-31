<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Bundle\SystemInfo\DependencyInjection\Compiler;

use Ibexa\Bundle\SystemInfo\SystemInfo\OutputFormatRegistry;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final readonly class OutputFormatPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->has(OutputFormatRegistry::class)) {
            return;
        }

        $outputFormattersTagged = $container->findTaggedServiceIds('ibexa.system_info.output.format');

        $outputFormatters = [];
        foreach ($outputFormattersTagged as $id => $tags) {
            foreach ($tags as $attributes) {
                $outputFormatters[$attributes['format']] = new Reference($id);
            }
        }

        $outputFormatRegistryDef = $container->findDefinition(OutputFormatRegistry::class);
        $outputFormatRegistryDef->setArguments([$outputFormatters]);
    }
}
