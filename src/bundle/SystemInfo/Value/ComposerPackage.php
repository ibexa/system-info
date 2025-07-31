<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Bundle\SystemInfo\SystemInfo\Value;

use DateTimeInterface;
use Ibexa\Contracts\Core\Repository\Values\ValueObject;

/**
 * Value for information about a Composer package.
 */
final class ComposerPackage extends ValueObject implements SystemInfo
{
    public string $name;

    public string $branch;

    public string $version;

    public ?string $alias = null;

    public ?string $license = null;

    public ?string $stability;

    public ?DateTimeInterface $dateTime;

    public ?string $homepage;

    public ?string $reference;
}
