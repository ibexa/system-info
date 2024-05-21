<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace Ibexa\Tests\SystemInfo\EventListener;

use Ibexa\AdminUi\Tab\Event\TabEvents;
use Ibexa\AdminUi\Tab\Event\TabGroupEvent;
use Ibexa\AdminUi\Tab\TabGroup;
use Ibexa\AdminUi\Tab\TabRegistry;
use Ibexa\Bundle\SystemInfo\SystemInfo\SystemInfoCollectorRegistry;
use Ibexa\SystemInfo\EventListener\SystemInfoTabGroupListener;
use Ibexa\SystemInfo\Tab\SystemInfo\SystemInfoTab;
use Ibexa\SystemInfo\Tab\SystemInfo\TabFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class SystemInfoTabGroupListenerTest extends TestCase
{
    /** @var \Symfony\Component\HttpFoundation\Request */
    private $request;

    /** @var \Ibexa\AdminUi\Tab\Event\TabGroupEvent */
    private $event;

    /** @var \Symfony\Component\HttpKernel\HttpKernelInterface|\PHPUnit\Framework\MockObject\MockObject */
    private $httpKernel;

    /** @var \PHPUnit\Framework\MockObject\MockObject|\Ibexa\AdminUi\Tab\TabRegistry */
    private $tabRegistry;

    /** @var \PHPUnit\Framework\MockObject\MockObject|\Ibexa\SystemInfo\Tab\SystemInfo\TabFactory */
    private $tabFactory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->tabRegistry = $this->createMock(TabRegistry::class);
        $this->tabFactory = $this->createMock(TabFactory::class);

        $this->request = $this->createMock(Request::class);

        $this->httpKernel = $this->createMock(HttpKernelInterface::class);
        $this->event = new TabGroupEvent();
    }

    public function testOnTabGroupPreRenderWithNoSystemInfoTabGroup()
    {
        $systemInfoCollectorRegistry = $this->createMock(SystemInfoCollectorRegistry::class);
        $systemInfoCollectorRegistry->expects(self::never())
            ->method('getIdentifiers');

        $systemInfoTabGroupListener = new SystemInfoTabGroupListener($this->tabRegistry, $this->tabFactory, $systemInfoCollectorRegistry);

        $tabGroup = new TabGroup('some_name', []);
        $this->event->setData($tabGroup);

        $systemInfoTabGroupListener->onTabGroupPreRender($this->event);
    }

    /**
     * @dataProvider dataProvider
     *
     * @param string[] $identifiers
     */
    public function testOnTabGroupPreRender(array $identifiers): void
    {
        $this->tabFactory
            ->expects(self::exactly(count($identifiers)))
            ->method('createTab')
            ->willReturnMap(
                [
                    ['identifier_1', null, $this->createMock(SystemInfoTab::class)],
                    ['identifier_2', null, $this->createMock(SystemInfoTab::class)],
                ]
            )
        ;

        $systemInfoCollectorRegistry = $this->createMock(SystemInfoCollectorRegistry::class);
        $systemInfoCollectorRegistry->expects(self::once())
            ->method('getIdentifiers')
            ->willReturn($identifiers);

        $systemInfoTabGroupListener = new SystemInfoTabGroupListener($this->tabRegistry, $this->tabFactory, $systemInfoCollectorRegistry);

        $tabGroup = new TabGroup('systeminfo', []);
        $this->event->setData($tabGroup);

        $systemInfoTabGroupListener->onTabGroupPreRender($this->event);
    }

    public function testSubscribedEvents()
    {
        $systemInfoCollectorRegistry = $this->createMock(SystemInfoCollectorRegistry::class);
        $systemInfoTabGroupListener = new SystemInfoTabGroupListener($this->tabRegistry, $this->tabFactory, $systemInfoCollectorRegistry);

        self::assertSame([TabEvents::TAB_GROUP_PRE_RENDER => ['onTabGroupPreRender', 10]], $systemInfoTabGroupListener::getSubscribedEvents());
    }

    public function dataProvider(): array
    {
        return [
            'two_identifiers' => [['identifier_1', 'identifier_2']],
            'one_identifiers' => [['identifier_1']],
            'no_identifiers' => [[]],
        ];
    }
}
