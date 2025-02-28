<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace Ibexa\Tests\Bundle\SystemInfo\SystemInfo\Collector;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Ibexa\Bundle\SystemInfo\SystemInfo\Collector\RepositorySystemInfoCollector;
use Ibexa\Bundle\SystemInfo\SystemInfo\Value\RepositoryMetrics;
use Ibexa\Bundle\SystemInfo\SystemInfo\Value\RepositorySystemInfo;
use Ibexa\SystemInfo\Storage\Metrics;
use Ibexa\SystemInfo\Storage\MetricsProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class RepositorySystemInfoCollectorTest extends TestCase
{
    private MockObject $dbalConnectionMock;

    private MockObject $dbalPlatformMock;

    private MockObject $metricsProviderMock;

    private MockObject $metricsMock;

    private RepositorySystemInfoCollector $repositoryCollector;

    protected function setUp(): void
    {
        $this->dbalConnectionMock = $this->getMockBuilder(Connection::class)->disableOriginalConstructor()->getMock();
        $this->dbalPlatformMock = $this->getMockBuilder(AbstractPlatform::class)->getMock();
        $this->metricsProviderMock = $this->createMock(MetricsProvider::class);
        $this->metricsMock = $this->createMock(Metrics::class);

        $this->repositoryCollector = new RepositorySystemInfoCollector(
            $this->dbalConnectionMock,
            $this->metricsProviderMock
        );
    }

    /**
     * @covers \RepositorySystemInfoCollector::collect
     */
    public function testCollect(): void
    {
        $expected = new RepositorySystemInfo([
            'type' => 'mysql',
            'name' => 'ezp_platform',
            'host' => 'localhost',
            'username' => 'ezp_user',
            'repositoryMetrics' => new RepositoryMetrics([
                'publishedCount' => 10,
                'usersCount' => 5,
                'draftsCount' => 20,
                'versionsCount' => 32,
                'contentTypesCount' => 8,
            ]),
        ]);

        $this->dbalConnectionMock
            ->expects(self::once())
            ->method('getDatabasePlatform')
            ->will(self::returnValue($this->dbalPlatformMock));

        $this->dbalPlatformMock
            ->expects(self::once())
            ->method('getName')
            ->will(self::returnValue($expected->type));

        $this->dbalConnectionMock
            ->expects(self::once())
            ->method('getDatabase')
            ->will(self::returnValue($expected->name));

        $this->dbalConnectionMock
            ->expects(self::once())
            ->method('getHost')
            ->will(self::returnValue($expected->host));

        $this->dbalConnectionMock
            ->expects(self::once())
            ->method('getUsername')
            ->will(self::returnValue($expected->username));

        $this->metricsProviderMock
            ->expects(self::exactly(5))
            ->method('provideMetrics')
            ->withConsecutive(
                ['published'],
                ['users'],
                ['drafts'],
                ['versions'],
                ['content_types']
            )
            ->willReturnOnConsecutiveCalls(
                $this->metricsMock,
                $this->metricsMock,
                $this->metricsMock,
                $this->metricsMock,
                $this->metricsMock,
            );

        $this->metricsMock
            ->expects(self::exactly(5))
            ->method('getValue')
            ->willReturnOnConsecutiveCalls(
                $expected->repositoryMetrics->publishedCount,
                $expected->repositoryMetrics->usersCount,
                $expected->repositoryMetrics->draftsCount,
                $expected->repositoryMetrics->versionsCount,
                $expected->repositoryMetrics->contentTypesCount,
            );

        $value = $this->repositoryCollector->collect();

        self::assertInstanceOf(RepositorySystemInfo::class, $value);
        self::assertEquals($expected, $value);
    }
}
