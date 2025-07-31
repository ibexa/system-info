<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Tests\Bundle\SystemInfo\SystemInfo\Collector;

use Ibexa\Bundle\SystemInfo\SystemInfo\Collector\ServicesSystemInfoCollector;
use Ibexa\Bundle\SystemInfo\SystemInfo\Value\ServicesSystemInfo;
use Ibexa\SystemInfo\Service\ServiceProviderInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class ServicesSystemInfoCollectorTest extends TestCase
{
    private ServiceProviderInterface&MockObject $serviceProviderMock;

    private ServicesSystemInfoCollector $serviceCollector;

    protected function setUp(): void
    {
        $this->serviceProviderMock = $this->createMock(ServiceProviderInterface::class);
        $this->serviceCollector = new ServicesSystemInfoCollector($this->serviceProviderMock);
    }

    public function testCollect(): void
    {
        $expected = new ServicesSystemInfo(
            'solr',
            'varnish',
            'redis'
        );

        $this->serviceProviderMock
            ->expects(self::exactly(3))
            ->method('getServiceType')
            ->withConsecutive(
                ['searchEngine'],
                ['httpCacheProxy'],
                ['persistenceCacheAdapter'],
            )
            ->willReturnOnConsecutiveCalls(
                $expected->getSearchEngine(),
                $expected->getHttpCacheProxy(),
                $expected->getPersistenceCacheAdapter(),
            );

        $value = $this->serviceCollector->collect();

        self::assertEquals($expected, $value);
    }
}
