<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace Ibexa\Tests\Bundle\SystemInfo\View;

use Ibexa\Bundle\SystemInfo\SystemInfo\Collector\SystemInfoCollector;
use Ibexa\Bundle\SystemInfo\SystemInfo\SystemInfoCollectorRegistry;
use Ibexa\Bundle\SystemInfo\SystemInfo\Value\SystemInfo;
use Ibexa\Bundle\SystemInfo\View\SystemInfoViewBuilder;
use Ibexa\Core\MVC\Symfony\View\Configurator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class SystemInfoViewBuilderTest extends TestCase
{
    private Configurator&MockObject $configuratorMock;

    private SystemInfoCollectorRegistry&MockObject $registryMock;

    private SystemInfoCollector&MockObject $collectorMock;

    public function testMatches(): void
    {
        $builder = new SystemInfoViewBuilder($this->getConfiguratorMock(), $this->getRegistryMock());
        self::assertTrue($builder->matches('ibexa.support_tools.view.controller::viewInfoAction'));
    }

    public function testNotMatches(): void
    {
        $builder = new SystemInfoViewBuilder($this->getConfiguratorMock(), $this->getRegistryMock());
        self::assertFalse($builder->matches('service::someAction'));
    }

    public function testBuildView(): void
    {
        $builder = new SystemInfoViewBuilder(
            $this->getConfiguratorMock(),
            $this->getRegistryMock()
        );

        $systemInfo = $this->createMock(SystemInfo::class);

        $this->getRegistryMock()
            ->method('getItem')
            ->with('test')
            ->will(self::returnValue($this->getCollectorMock()));

        $this->getCollectorMock()
            ->method('collect')
            ->will(self::returnValue($systemInfo));

        $view = $builder->buildView(['systemInfoIdentifier' => 'test', 'viewType' => 'test']);
        self::assertSame($view->getInfo(), $systemInfo);
        self::assertEquals($view->getViewType(), 'test');
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject&\Ibexa\Core\MVC\Symfony\View\Configurator
     */
    protected function getConfiguratorMock(): Configurator
    {
        $this->configuratorMock ??= $this->createMock(Configurator::class);

        return $this->configuratorMock;
    }

    protected function getRegistryMock(): SystemInfoCollectorRegistry&MockObject
    {
        $this->registryMock ??= $this->createMock(
            SystemInfoCollectorRegistry::class
        );

        return $this->registryMock;
    }

    protected function getCollectorMock(): SystemInfoCollector&MockObject
    {
        $this->collectorMock ??= $this->createMock(SystemInfoCollector::class);

        return $this->collectorMock;
    }
}
