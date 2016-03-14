<?php

/**
 * File containing the ComposerPackage class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace EzSystems\EzSupportToolsBundle\SystemInfo\Value;

use eZ\Publish\API\Repository\Values\ValueObject;

/**
 * Value for information about a Composer package.
 */
class ComposerPackage extends ValueObject implements SystemInfo
{
    /**
     * Name.
     *
     * Example: ezsystems/ezpublish-kernel
     *
     * @var string
     */
    public $name;

    /**
     * Version.
     *
     * Example: v2.7.10
     *
     * @var string
     */
    public $version;

    /**
     * Stability.
     *
     * One of: stable, RC, beta, alpha, dev, or null if not set.
     *
     * @var string|null
     */
    public $stability;

    /**
     * Date and time.
     *
     * @var \DateTime
     */
    public $dateTime;

    /**
     * Homepage URL, or null of not set.
     *
     * Example: https://symfony.com
     *
     * @var string|null
     */
    public $homepage;

    /**
     * Reference.
     *
     * Example: 9a3b6bf6ebee49370aaf15abc1bdeb4b1986a67d
     *
     * @var string
     */
    public $reference;
}
