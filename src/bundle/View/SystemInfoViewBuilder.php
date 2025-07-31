<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Bundle\SystemInfo\View;

use Ibexa\Bundle\SystemInfo\SystemInfo\Collector\SystemInfoCollector;
use Ibexa\Bundle\SystemInfo\SystemInfo\Exception\SystemInfoException;
use Ibexa\Bundle\SystemInfo\SystemInfo\SystemInfoCollectorRegistry;
use Ibexa\Bundle\SystemInfo\SystemInfo\Value\InvalidSystemInfo;
use Ibexa\Core\MVC\Symfony\View\Builder\ViewBuilder;
use Ibexa\Core\MVC\Symfony\View\Configurator;

final readonly class SystemInfoViewBuilder implements ViewBuilder
{
    public function __construct(
        private Configurator $viewConfigurator,
        private SystemInfoCollectorRegistry $registry
    ) {
    }

    public function matches(mixed $argument): bool
    {
        return $argument === 'ibexa.support_tools.view.controller::viewInfoAction';
    }

    /**
     * @param array<string, string> $parameters
     *
     * @throws \Ibexa\Contracts\Core\Repository\Exceptions\InvalidArgumentException
     * @throws \Ibexa\Contracts\Core\Repository\Exceptions\NotFoundException
     */
    public function buildView(array $parameters): SystemInfoView
    {
        $collector = $this->getCollector($parameters['systemInfoIdentifier']);
        $view = new SystemInfoView(null, [], $parameters['viewType']);

        try {
            $collectedData = $collector->collect();
        } catch (SystemInfoException $e) {
            $collectedData = new InvalidSystemInfo();
            $collectedData->errorMessage = $e->getMessage();
        }

        $view->setInfo($collectedData);
        $this->viewConfigurator->configure($view);

        return $view;
    }

    /**
     * @throws \Ibexa\Contracts\Core\Repository\Exceptions\NotFoundException
     */
    private function getCollector(string $identifier): SystemInfoCollector
    {
        return $this->registry->getItem($identifier);
    }
}
