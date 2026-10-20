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
        $matcher = self::exactly(3);

        $this->serviceProviderMock
            ->expects($matcher)
            ->method('getServiceType')->willReturnCallback(static function (...$parameters) use ($matcher, $expected): string {
                if ($matcher->numberOfInvocations() === 1) {
                    self::assertSame('searchEngine', $parameters[0]);

                    return $expected->getSearchEngine();
                }
                if ($matcher->numberOfInvocations() === 2) {
                    self::assertSame('httpCacheProxy', $parameters[0]);

                    return $expected->getHttpCacheProxy();
                }
                self::assertSame('persistenceCacheAdapter', $parameters[0]);

                return $expected->getPersistenceCacheAdapter();
            });

        $value = $this->serviceCollector->collect();

        self::assertEquals($expected, $value);
    }
}
