<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Bundle\SystemInfo\SystemInfo\Value;

use Ibexa\Contracts\Core\Repository\Values\ValueObject;

/**
 * Value for information about the database we are using.
 */
final class RepositorySystemInfo extends ValueObject implements SystemInfo
{
    public string $type;

    public string $name;

    public string $host;

    public string $username;

    public RepositoryMetrics $repositoryMetrics;
}
