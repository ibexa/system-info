<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\SystemInfo\Storage\Metrics;

use Ibexa\Contracts\Core\Persistence\Content\ContentInfo;
use Ibexa\Core\Persistence\Legacy\Content\Gateway as ContentGateway;

/**
 * @internal
 */
final class PublishedContentObjectsCountMetrics extends RepositoryConnectionAwareMetrics
{
    private const string ID_COLUMN = 'id';
    private const string STATUS_COLUMN = 'status';

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function getValue(): int
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->select($this->getCountExpression(self::ID_COLUMN))
            ->from(ContentGateway::CONTENT_ITEM_TABLE)
            ->where(
                $queryBuilder->expr()->eq(self::STATUS_COLUMN, ContentInfo::STATUS_PUBLISHED)
            );

        return (int)$queryBuilder->executeQuery()->fetchOne();
    }
}
