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
    /** @var \Symfony\Bridge\Twig\Extension\HttpKernelRuntime */
    protected $httpKernelRuntime;

    /** @var \Twig\Environment */
    protected $twig;

    /** @var \Symfony\Contracts\Translation\TranslatorInterface */
    protected $translator;

    /**
     * @param \Twig\Environment $twig
     * @param \Symfony\Contracts\Translation\TranslatorInterface $translator
     * @param \Symfony\Bridge\Twig\Extension\HttpKernelRuntime $httpKernelRuntime
     */
    public function __construct(
        Environment $twig,
        TranslatorInterface $translator,
        HttpKernelRuntime $httpKernelRuntime
    ) {
        $this->twig = $twig;
        $this->translator = $translator;
        $this->httpKernelRuntime = $httpKernelRuntime;
    }

    /**
     * @param string $collectorIdentifier
     * @param string|null $tabIdentifier
     *
     * @return SystemInfoTab
     */
    public function createTab(string $collectorIdentifier, ?string $tabIdentifier = null): SystemInfoTab
    {
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

class_alias(TabFactory::class, 'EzSystems\EzSupportTools\Tab\SystemInfo\TabFactory');
