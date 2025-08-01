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
    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function getValue(): int
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $expr = $queryBuilder->expr();

        $queryBuilder
            ->select($this->getCountExpression('v.id'))
            ->from(ContentGateway::CONTENT_VERSION_TABLE, 'v')
            ->innerJoin(
                'v',
                ContentGateway::CONTENT_ITEM_TABLE,
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

        return (int)$queryBuilder->executeQuery()->fetchOne();
    }
}
