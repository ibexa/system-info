<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Tests\Bundle\SystemInfo\SystemInfo\Collector;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Platforms\AbstractMySQLPlatform;
use Ibexa\Bundle\SystemInfo\SystemInfo\Collector\RepositorySystemInfoCollector;
use Ibexa\Bundle\SystemInfo\SystemInfo\Value\RepositoryMetrics;
use Ibexa\Bundle\SystemInfo\SystemInfo\Value\RepositorySystemInfo;
use Ibexa\SystemInfo\Storage\Metrics;
use Ibexa\SystemInfo\Storage\MetricsProvider;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;

#[CoversMethod(RepositorySystemInfoCollector::class, 'collect')]
final class RepositorySystemInfoCollectorTest extends TestCase
{
    private Connection&MockObject $dbalConnectionMock;

    private AbstractMySQLPlatform&Stub $dbalPlatformMock;

    private MetricsProvider&MockObject $metricsProviderMock;

    private Metrics&MockObject $metricsMock;

    private RepositorySystemInfoCollector $repositoryCollector;

    protected function setUp(): void
    {
        $this->dbalConnectionMock = $this->createMock(Connection::class);
        $this->dbalPlatformMock = self::createStub(AbstractMySQLPlatform::class);
        $this->metricsProviderMock = $this->createMock(MetricsProvider::class);
        $this->metricsMock = $this->createMock(Metrics::class);

        $this->repositoryCollector = new RepositorySystemInfoCollector(
            $this->dbalConnectionMock,
            $this->metricsProviderMock
        );
    }

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
        $matcher = self::exactly(5);

        $this->metricsProviderMock
            ->expects($matcher)
            ->method('provideMetrics')->willReturnCallback(function (...$parameters) use ($matcher): Metrics {
                if ($matcher->numberOfInvocations() === 1) {
                    self::assertSame('published', $parameters[0]);

                    return $this->metricsMock;
                }
                if ($matcher->numberOfInvocations() === 2) {
                    self::assertSame('users', $parameters[0]);

                    return $this->metricsMock;
                }
                if ($matcher->numberOfInvocations() === 3) {
                    self::assertSame('drafts', $parameters[0]);

                    return $this->metricsMock;
                }
                if ($matcher->numberOfInvocations() === 4) {
                    self::assertSame('versions', $parameters[0]);

                    return $this->metricsMock;
                }
                self::assertSame('content_types', $parameters[0]);

                return $this->metricsMock;
            });

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
