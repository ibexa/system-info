<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

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

final class RepositorySystemInfoCollectorTest extends TestCase
{
    private Connection&MockObject $dbalConnectionMock;

    private AbstractPlatform&MockObject $dbalPlatformMock;

    private MetricsProvider&MockObject $metricsProviderMock;

    private Metrics&MockObject $metricsMock;

    private RepositorySystemInfoCollector $repositoryCollector;

    protected function setUp(): void
    {
        $this->dbalConnectionMock = $this->createMock(Connection::class);
        $this->dbalPlatformMock = $this->createMock(AbstractPlatform::class);
        $this->metricsProviderMock = $this->createMock(MetricsProvider::class);
        $this->metricsMock = $this->createMock(Metrics::class);

        $this->repositoryCollector = new RepositorySystemInfoCollector(
            $this->dbalConnectionMock,
            $this->metricsProviderMock
        );
    }

    /**
     * @covers \Ibexa\Bundle\SystemInfo\SystemInfo\Collector\RepositorySystemInfoCollector::collect()
     */
    public function testCollect(): void
    {
        $expected = new RepositorySystemInfo([
            'type' => 'mysql',
            'name' => 'ibexa_db',
            'host' => 'localhost',
            'username' => 'ibexa_user',
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
            ->willReturn($this->dbalPlatformMock);

        $this->dbalPlatformMock
            ->expects(self::once())
            ->method('getName')
            ->willReturn($expected->type);

        $this->dbalConnectionMock
            ->expects(self::once())
            ->method('getDatabase')
            ->willReturn($expected->name);

        $this->dbalConnectionMock
            ->expects(self::once())
            ->method('getParams')
            ->willReturn([
                'host' => $expected->host,
                'user' => $expected->username,
            ]);

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

        self::assertEquals($expected, $value);
    }
}
