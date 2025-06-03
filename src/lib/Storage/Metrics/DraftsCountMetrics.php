<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\SystemInfo\Storage\Metrics;

use Doctrine\DBAL\ParameterType;
use Ibexa\Contracts\Core\Persistence\Content\ContentInfo;
use Ibexa\Core\Persistence\Legacy\Content\Gateway as ContentGateway;

/**
 * @internal
 */
final class DraftsCountMetrics extends RepositoryConnectionAwareMetrics
{
    private const string CONTENTOBJECT_VERSION_TABLE = ContentGateway::CONTENT_VERSION_TABLE;
    private const string CONTENTOBJECT_TABLE = ContentGateway::CONTENT_ITEM_TABLE;

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function getValue(): int
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $expr = $queryBuilder->expr();

        $queryBuilder
            ->select($this->getCountExpression('v.id'))
            ->from(self::CONTENTOBJECT_VERSION_TABLE, 'v')
            ->innerJoin(
                'v',
                self::CONTENTOBJECT_TABLE,
                'c',
                $expr->and(
                    $expr->eq('c.id', 'v.contentobject_id'),
                    $expr->neq('c.status', ContentInfo::STATUS_TRASHED)
                )
            )
            ->where(
                $queryBuilder->expr()->eq('v.status', ':status')
            )
            ->setParameter('status', ContentInfo::STATUS_DRAFT, ParameterType::INTEGER);

        return (int) $queryBuilder->executeQuery()->fetchFirstColumn();
    }
}
