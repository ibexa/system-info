<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Bundle\SystemInfo\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Symfony extension configuration definition for ibexa_system_info extension.
 *
 * @internal
 */
final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder(IbexaSystemInfoExtension::EXTENSION_NAME);
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->arrayNode('system_info')
                    ->info('System info configuration, provided by "ez-support-tools" package')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('powered_by')
                            ->info('Control if system should generate a powered by header to promote eZ Platform usage')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->booleanNode('enabled')
                                    ->info('Activate/Deactivate powered by header')
                                    ->defaultValue(true)
                                ->end()
                                ->enumNode('release')
                                    ->info('Sets how much of version info is exposed in powered by. Examples:  minor: "2.5", major: "2", none: ""')
                                    ->values(['major', 'minor', 'none'])
                                    ->defaultValue('major')
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}

class_alias(Configuration::class, 'EzSystems\EzSupportToolsBundle\DependencyInjection\Configuration');
