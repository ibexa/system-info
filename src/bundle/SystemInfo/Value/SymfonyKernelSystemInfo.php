<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Bundle\SystemInfo\SystemInfo\Value;

use Ibexa\Contracts\Core\Repository\Values\ValueObject;

/**
 * Value for information about the Symfony kernel we are using.
 */
final class SymfonyKernelSystemInfo extends ValueObject implements SystemInfo
{
    public string $environment;

    public bool $debugMode;

    public string $version;

    /**
     * Installed bundles.
     *
     * A hash containing the active bundles, where the key is the bundle name, and the value is the corresponding namespace.
     *
     * Example:
     * array (
     *   'AppBundle' => 'AppBundle\\AppBundle',
     *   'AsseticBundle' => 'Symfony\\Bundle\\AsseticBundle\\AsseticBundle',
     * )
     *
     * @var array<string, class-string>
     */
    public array $bundles;

    public string $projectDir;

    public string $cacheDir;

    public string $logDir;

    public string $charset;
}
