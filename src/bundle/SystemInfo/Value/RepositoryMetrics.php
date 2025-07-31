<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Bundle\SystemInfo\SystemInfo\Value;

use Ibexa\Contracts\Core\Repository\Values\ValueObject;

/**
 * Value for various repository metrics (content object count, user count etc.).
 */
final class RepositoryMetrics extends ValueObject implements SystemInfo
{
    public int $publishedCount;

    public int $usersCount;

    public int $draftsCount;

    public int $versionsCount;

    public int $contentTypesCount;
}
