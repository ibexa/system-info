<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Tests\Bundle\SystemInfo\DependencyInjection\Compiler;

use Ibexa\AdminUi\Tab\TabGroup;
use Ibexa\AdminUi\Tab\TabRegistry;
use Ibexa\Bundle\SystemInfo\DependencyInjection\Compiler\SystemInfoTabGroupPass;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class SystemInfoTabGroupPassTest extends AbstractCompilerPassTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->setDefinition(TabRegistry::class, new Definition());
    }

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    protected function registerCompilerPass(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new SystemInfoTabGroupPass());
    }

    public function testProcess(): void
    {
        $tabGroupDefinition = new Definition(TabGroup::class, ['systeminfo']);

        $this->compile();

        $this->assertContainerBuilderHasServiceDefinitionWithMethodCall(
            TabRegistry::class,
            'addTabGroup',
            [$tabGroupDefinition]
        );
    }
}
