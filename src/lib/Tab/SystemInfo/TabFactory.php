<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\SystemInfo\Tab\SystemInfo;

use Symfony\Bridge\Twig\Extension\HttpKernelRuntime;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;

class TabFactory
{
    public function __construct(
        private readonly Environment $twig,
        private readonly TranslatorInterface $translator,
        private readonly HttpKernelRuntime $httpKernelRuntime
    ) {
    }

    public function createTab(
        string $collectorIdentifier,
        ?string $tabIdentifier = null
    ): SystemInfoTab {
        $tabIdentifier = $tabIdentifier ?? $collectorIdentifier;

        return new SystemInfoTab(
            $this->twig,
            $this->translator,
            $this->httpKernelRuntime,
            $tabIdentifier,
            $collectorIdentifier
        );
    }
}
