<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace Ibexa\Tests\Bundle\SystemInfo\View;

use Ibexa\Bundle\SystemInfo\SystemInfo\Value\SystemInfo;
use Ibexa\Bundle\SystemInfo\View\SystemInfoViewBuilder;
use PHPUnit\Framework\TestCase;

class SystemInfoViewBuilderTest extends TestCase
{
    private $configuratorMock;

    private $registryMock;

    private $collectorMock;

    public function testMatches()
    {
        $builder = new SystemInfoViewBuilder($this->getConfiguratorMock(), $this->getRegistryMock());
        self::assertTrue($builder->matches('ibexa.support_tools.view.controller:viewInfoAction'));
    }

    public function testNotMatches()
    {
        $builder = new SystemInfoViewBuilder($this->getConfiguratorMock(), $this->getRegistryMock());
        self::assertFalse($builder->matches('service:someAction'));
    }

    public function testBuildView()
    {
        $builder = new SystemInfoViewBuilder(
            $this->getConfiguratorMock(),
            $this->getRegistryMock()
        );

        $systemInfo = $this->createMock(SystemInfo::class);

        $this->getRegistryMock()
            ->method('getItem')
            ->with('test')
            ->will($this->returnValue($this->getCollectorMock()));

        $this->getCollectorMock()
            ->method('collect')
            ->will($this->returnValue($systemInfo));

        $view = $builder->buildView(['systemInfoIdentifier' => 'test', 'viewType' => 'test']);
        self::assertSame($view->getInfo(), $systemInfo);
        self::assertEquals($view->getViewType(), 'test');
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|\Ibexa\Core\MVC\Symfony\View\Configurator
     */
    protected function getConfiguratorMock()
    {
        if (!isset($this->configuratorMock)) {
            $this->configuratorMock = $this->createMock('Ibexa\\Core\\MVC\\Symfony\\View\\Configurator');
        }

        return $this->configuratorMock;
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|\Ibexa\Bundle\SystemInfo\SystemInfo\SystemInfoCollectorRegistry
     */
    protected function getRegistryMock()
    {
        if (!isset($this->registryMock)) {
            $this->registryMock = $this->createMock('Ibexa\\Bundle\\SystemInfo\\SystemInfo\\SystemInfoCollectorRegistry');
        }

        return $this->registryMock;
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|\Ibexa\Bundle\SystemInfo\SystemInfo\Collector\SystemInfoCollector
     */
    protected function getCollectorMock()
    {
        if (!isset($this->collectorMock)) {
            $this->collectorMock = $this->createMock('Ibexa\\Bundle\\SystemInfo\\SystemInfo\\Collector\\SystemInfoCollector');
        }

        return $this->collectorMock;
    }
}

class_alias(SystemInfoViewBuilderTest::class, 'EzSystems\EzSupportToolsBundle\Tests\View\SystemInfoViewBuilderTest');
