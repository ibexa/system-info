<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\SystemInfo\Storage\Metrics;

use Ibexa\Contracts\Core\Persistence\Content\Type;
use Ibexa\Core\Persistence\Legacy\Content\Type\Gateway as ContentTypeGateway;

/**
 * @internal
 */
final class ContentTypesCountMetrics extends RepositoryConnectionAwareMetrics
{
    private const CONTENT_TYPE_TABLE = ContentTypeGateway::CONTENT_TYPE_TABLE;
    private const ID_COLUMN = 'id';
    private const VERSION_COLUMN = 'version';

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function getValue(): int
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->select($this->getCountExpression(self::ID_COLUMN))
            ->from(self::CONTENT_TYPE_TABLE)
            ->where(
                $queryBuilder->expr()->eq(self::VERSION_COLUMN, Type::STATUS_DEFINED)
            );

        return (int) $queryBuilder->executeQuery()->fetchFirstColumn();
    }
}
