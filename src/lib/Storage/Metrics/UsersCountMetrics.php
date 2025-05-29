<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\SystemInfo\Storage\Metrics;

use Ibexa\Core\Persistence\Legacy\User\Gateway as UserGateway;

/**
 * @internal
 */
final class UsersCountMetrics extends RepositoryConnectionAwareMetrics
{
    private const USER_TABLE = UserGateway::USER_TABLE;
    private const CONTENTOBJECT_ID_COLUMN = 'contentobject_id';

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function getValue(): int
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->select($this->getCountExpression(self::CONTENTOBJECT_ID_COLUMN))
            ->from(self::USER_TABLE);

        return (int) $queryBuilder->executeQuery()->fetchFirstColumn();
    }
}
