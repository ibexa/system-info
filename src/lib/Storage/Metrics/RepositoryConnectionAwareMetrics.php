<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\SystemInfo\Storage\Metrics;

use Doctrine\DBAL\Connection;
use Ibexa\SystemInfo\Storage\Metrics;

/**
 * @internal
 */
abstract class RepositoryConnectionAwareMetrics implements Metrics
{
    protected Connection $connection;

    abstract public function getValue(): int;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    protected function getCountExpression(string $columnName): string
    {
        return $this->connection->getDatabasePlatform()->getCountExpression($columnName);
    }
}
