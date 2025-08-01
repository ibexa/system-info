<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Bundle\SystemInfo\SystemInfo\Collector;

use Doctrine\DBAL\Connection;
use Ibexa\Bundle\SystemInfo\SystemInfo\Value\RepositoryMetrics;
use Ibexa\Bundle\SystemInfo\SystemInfo\Value\RepositorySystemInfo;
use Ibexa\SystemInfo\Storage\MetricsProvider;

/**
 * Collects database information using Doctrine.
 */
readonly class RepositorySystemInfoCollector implements SystemInfoCollector
{
    public function __construct(
        private Connection $connection,
        private MetricsProvider $metricsProvider
    ) {
    }

    /**
     * Collects information about the database Ibexa DXP is using.
     *  - type
     *  - name
     *  - host
     *  - username
     *  - repository metrics (containing count of content objects, users, drafts etc.).
     */
    public function collect(): RepositorySystemInfo
    {
        $params = $this->connection->getParams();

        return new RepositorySystemInfo([
            'type' => $this->connection->getDatabasePlatform()->getName(),
            'name' => $this->connection->getDatabase(),
            'host' => $params['host'] ?? '',
            'username' => $params['user'] ?? '',
            'repositoryMetrics' => $this->populateRepositoryMetricsData(),
        ]);
    }

    private function populateRepositoryMetricsData(): RepositoryMetrics
    {
        return new RepositoryMetrics([
            'publishedCount' => $this->metricsProvider->provideMetrics('published')->getValue(),
            'usersCount' => $this->metricsProvider->provideMetrics('users')->getValue(),
            'draftsCount' => $this->metricsProvider->provideMetrics('drafts')->getValue(),
            'versionsCount' => $this->metricsProvider->provideMetrics('versions')->getValue(),
            'contentTypesCount' => $this->metricsProvider->provideMetrics('content_types')->getValue(),
        ]);
    }
}
