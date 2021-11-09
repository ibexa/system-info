<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace Ibexa\Tests\Bundle\SystemInfo\SystemInfo\Collector;

use Ibexa\Bundle\SystemInfo\SystemInfo\Collector\ServicesSystemInfoCollector;
use Ibexa\Bundle\SystemInfo\SystemInfo\Value\ServicesSystemInfo;
use Ibexa\SystemInfo\Service\Service;
use Ibexa\SystemInfo\Service\ServiceProviderInterface;
use PHPUnit\Framework\TestCase;

class ServicesSystemInfoCollectorTest extends TestCase
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    private $serviceProviderMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    private $serviceMock;

    /**
     * @var \Ibexa\Bundle\SystemInfo\SystemInfo\Collector\ServicesSystemInfoCollector
     */
    private $serviceCollector;

    protected function setUp(): void
    {
        $this->serviceProviderMock = $this->createMock(ServiceProviderInterface::class);
        $this->serviceMock = $this->createMock(Service::class);

        $this->serviceCollector = new ServicesSystemInfoCollector($this->serviceProviderMock);
    }

    /**
     * @covers \Ibexa\Bundle\SystemInfo\SystemInfo\Collector\ServicesSystemInfoCollector::collect()
     */
    public function testCollect(): void
    {
        $expected = new ServicesSystemInfo([
            'searchEngine' => 'solr',
            'httpCacheProxy' => 'varnish',
            'persistenceCacheAdapter' => 'redis',
        ]);

        $this->serviceProviderMock
            ->expects($this->exactly(3))
            ->method('provide')
            ->withConsecutive(
                ['searchEngine'],
                ['httpCacheProxy'],
                ['persistenceCacheAdapter'],
            )
            ->willReturnOnConsecutiveCalls(
                $this->serviceMock,
                $this->serviceMock,
                $this->serviceMock,
            );

        $this->serviceMock
            ->expects($this->exactly(3))
            ->method('getValue')
            ->willReturnOnConsecutiveCalls(
                $expected->searchEngine,
                $expected->httpCacheProxy,
                $expected->persistenceCacheAdapter,
            );

        $value = $this->serviceCollector->collect();

        self::assertEquals($expected, $value);
    }
}

class_alias(ServicesSystemInfoCollectorTest::class, 'EzSystems\EzSupportToolsBundle\Tests\SystemInfo\Collector\ServicesSystemInfoCollectorTest');
