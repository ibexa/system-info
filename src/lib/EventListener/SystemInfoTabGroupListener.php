<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\SystemInfo\EventListener;

use Ibexa\AdminUi\Tab\Event\TabEvents;
use Ibexa\AdminUi\Tab\Event\TabGroupEvent;
use Ibexa\Bundle\SystemInfo\SystemInfo\SystemInfoCollectorRegistry;
use Ibexa\SystemInfo\Tab\SystemInfo\TabFactory;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final readonly class SystemInfoTabGroupListener implements EventSubscriberInterface
{
    public function __construct(
        private TabFactory $tabFactory,
        private SystemInfoCollectorRegistry $systeminfoCollectorRegistry
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            TabEvents::TAB_GROUP_PRE_RENDER => ['onTabGroupPreRender', 10],
        ];
    }

    public function onTabGroupPreRender(TabGroupEvent $event): void
    {
        $tabGroup = $event->getData();
        if ('systeminfo' !== $tabGroup->getIdentifier()) {
            return;
        }

        foreach ($this->systeminfoCollectorRegistry->getIdentifiers() as $collectorIdentifier) {
            $tabGroup->addTab($this->tabFactory->createTab($collectorIdentifier));
        }
    }
}
