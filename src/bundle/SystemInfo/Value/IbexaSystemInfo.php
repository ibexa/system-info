<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Bundle\SystemInfo\SystemInfo\Value;

use DateTime;
use Ibexa\Contracts\Core\Repository\Values\ValueObject;

/**
 * Value for information about the Ibexa installation.
 *
 * @internal This class will greatly change in the future and should not be used as an api.
 */
final class IbexaSystemInfo extends ValueObject implements SystemInfo
{
    public const string PRODUCT_NAME_OSS = 'Ibexa Open Source';

    public const array PRODUCT_NAME_VARIANTS = [
        'oss' => self::PRODUCT_NAME_OSS,
        'headless' => 'Ibexa Headless',
        'experience' => 'Ibexa Experience',
        'commerce' => 'Ibexa Commerce',
    ];

    public string $name = self::PRODUCT_NAME_OSS;

    public ?string $release;

    public bool $isEnterprise = false;

    public bool $isCommerce = false;

    /**
     * @uses $endOfMaintenanceDate
     */
    public bool $isEndOfMaintenance = true;

    /**
     * @var \DateTime|null EOM for the given release, if you have an Ibexa DXP / Enterpise susbscription.
     *
     * @see https://support.ibexa.co/Public/Service-Life
     */
    public ?DateTime $endOfMaintenanceDate;

    /**
     * @uses $endOfLifeDate
     */
    public bool $isEndOfLife = true;

    /**
     * @var \DateTime|null EOL for the given release, if you have an Ibexa DXP susbscription.
     *
     * @see https://support.ibexa.co/Public/Service-Life
     */
    public ?DateTime $endOfLifeDate;

    public bool $isTrial = false;

    /**
     * Lowest stability found in the installation (packages / minimumStability).
     *
     * @var string One of {@see \Ibexa\SystemInfo\Value\Stability::STABILITIES}.
     */
    public string $lowestStability;
}
