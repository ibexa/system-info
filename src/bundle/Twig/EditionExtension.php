<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Bundle\SystemInfo\Twig;

use Composer\InstalledVersions;
use Ibexa\Bundle\SystemInfo\SystemInfo\Collector\IbexaSystemInfoCollector;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class EditionExtension extends AbstractExtension
{
    private const IBEXA_EDITION_OSS = 'oss';
    private const IBEXA_EDITION_CONTENT = 'content';
    private const IBEXA_EDITION_EXPERIENCE = 'experience';
    private const IBEXA_EDITION_COMMERCE = 'commerce';

    private const IBEXA_EDITIONS = [
        self::IBEXA_EDITION_OSS,
        self::IBEXA_EDITION_CONTENT,
        self::IBEXA_EDITION_EXPERIENCE,
        self::IBEXA_EDITION_COMMERCE,
    ];

    /**
     * @return \Twig\TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'ibexa_edition',
                [$this, 'isIbexaEdition']
            ),
            new TwigFunction(
                'ibexa_edition_at_least',
                [$this, 'isIbexaEditionAtLeast']
            ),
        ];
    }

    public function isIbexaEdition(string $edition): bool
    {
        if (!in_array($edition, self::IBEXA_EDITIONS)) {
            return false;
        }

        return self::getEdition() === $edition;
    }

    public function isIbexaEditionAtLeast(string $edition): bool
    {
        if (!in_array($edition, self::IBEXA_EDITIONS)) {
            return false;
        }

        $current = array_search(self::getEdition(), self::IBEXA_EDITIONS);
        $tested =  array_search($edition, self::IBEXA_EDITIONS);

        return $tested >= $current;
    }

    private static function getEdition(): string
    {
        if (InstalledVersions::isInstalled(IbexaSystemInfoCollector::COMMERCE_PACKAGES[0])) {
            return self::IBEXA_EDITION_COMMERCE;
        } else if (InstalledVersions::isInstalled(IbexaSystemInfoCollector::EXPERIENCE_PACKAGES[0])) {
            return self::IBEXA_EDITION_EXPERIENCE;
        } else if (InstalledVersions::isInstalled(IbexaSystemInfoCollector::CONTENT_PACKAGES[0])) {
            return self::IBEXA_EDITION_CONTENT;
        }

        return self::IBEXA_EDITION_OSS;
    }
}
