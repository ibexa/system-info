<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace Ibexa\Bundle\SystemInfo\SystemInfo\Value;

use Ibexa\Contracts\Core\Repository\Values\ValueObject;

/**
 * Value for information about the Symfony kernel we are using.
 */
class SymfonyKernelSystemInfo extends ValueObject implements SystemInfo
{
    /**
     * Symfony environment.
     *
     * "dev" or "prod".
     *
     * @var string
     */
    public $environment;

    /**
     * True if Symfony is in debug mode.
     *
     * @var bool
     */
    public $debugMode;

    /**
     * Symfony version.
     *
     * Example: 2.7.10
     *
     * @var string
     */
    public $version;

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
     * @var array
     */
    public $bundles;

    /**
     * Project directory.
     *
     * Example: /srv/www/ibexa-dxp/app
     *
     * @var string
     */
    public $projectDir;

    /**
     * Cache directory.
     *
     * Example: /srv/www/ibexa-dxp/app/cache/prod
     *
     * @var string
     */
    public $cacheDir;

    /**
     * Log file directory.
     *
     * Example: /srv/www/ibexa-dxp/app/logs
     *
     * @var string
     */
    public $logDir;

    /**
     * Character set.
     *
     * Example: UTF-8
     *
     * @var string
     */
    public $charset;
}

class_alias(SymfonyKernelSystemInfo::class, 'EzSystems\EzSupportToolsBundle\SystemInfo\Value\SymfonyKernelSystemInfo');
