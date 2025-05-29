<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\SystemInfo\Storage\Metrics;

use Ibexa\Core\Persistence\Legacy\Content\Gateway as ContentGateway;

/**
 * @internal
 */
final class VersionsCountMetrics extends RepositoryConnectionAwareMetrics
{
    private const CONTENTOBJECT_VERSION_TABLE = ContentGateway::CONTENT_VERSION_TABLE;
    private const ID_COLUMN = 'id';

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function getValue(): int
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->select($this->getCountExpression(self::ID_COLUMN))
            ->from(self::CONTENTOBJECT_VERSION_TABLE);

        return (int) $queryBuilder->executeQuery()->fetchFirstColumn();
    }
}
