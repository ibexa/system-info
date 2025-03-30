<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace Ibexa\Bundle\SystemInfo\SystemInfo\Collector;

use Doctrine\DBAL\Connection;
use Ibexa\Bundle\SystemInfo\SystemInfo\Value\RepositoryMetrics;
use Ibexa\Bundle\SystemInfo\SystemInfo\Value\RepositorySystemInfo;
use Ibexa\SystemInfo\Storage\MetricsProvider;

/**
 * Collects database information using Doctrine.
 */
class RepositorySystemInfoCollector implements SystemInfoCollector
{
    /**
     * The database connection, only used to retrieve some information on the database itself.
     */
    private Connection $connection;

    /**
     * The metrics provider needed to populate Repository value object consisting of several metrics.
     */
    private MetricsProvider $metricsProvider;

    public function __construct(Connection $db, MetricsProvider $metricsProvider)
    {
        $this->connection = $db;
        $this->metricsProvider = $metricsProvider;
    }

    /**
     * Collects information about the database Ibexa DXP is using.
     *  - type
     *  - name
     *  - host
     *  - username
     *  - repository metrics (containing count of content objects, users, drafts etc.).
     *
     * @return \Ibexa\Bundle\SystemInfo\SystemInfo\Value\RepositorySystemInfo
     */
    public function collect(): RepositorySystemInfo
    {
        return new RepositorySystemInfo([
            'type' => $this->connection->getDatabasePlatform()->getName(),
            'name' => $this->connection->getDatabase(),
            'host' => $this->connection->getHost(),
            'username' => $this->connection->getUsername(),
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
