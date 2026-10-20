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
    abstract public function getValue(): int;

    public function __construct(protected Connection $connection)
    {
    }

    protected function getCountExpression(string $columnName): string
    {
        return 'COUNT(' . $this->quoteQualifiedIdentifier($columnName) . ')';
    }

    /**
     * Quotes a possibly qualified identifier (e.g. `alias.column`), quoting each dot-separated
     * part individually, since {@see Connection::quoteIdentifier()} is deprecated in favor of
     * quoting each part with {@see Connection::quoteSingleIdentifier()}.
     */
    private function quoteQualifiedIdentifier(string $columnName): string
    {
        return implode(
            '.',
            array_map(
                fn (string $part): string => $this->connection->quoteSingleIdentifier($part),
                explode('.', $columnName),
            ),
        );
    }
}
