<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace Ibexa\SystemInfo\EventListener;

use Ibexa\AdminUi\Tab\Event\TabEvents;
use Ibexa\AdminUi\Tab\Event\TabGroupEvent;
use Ibexa\AdminUi\Tab\TabRegistry;
use Ibexa\Bundle\SystemInfo\SystemInfo\SystemInfoCollectorRegistry;
use Ibexa\SystemInfo\Tab\SystemInfo\TabFactory;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class SystemInfoTabGroupListener implements EventSubscriberInterface
{
    protected TabRegistry $tabRegistry;

    protected TabFactory $tabFactory;

    protected SystemInfoCollectorRegistry $systeminfoCollectorRegistry;

    /**
     * @param \Ibexa\AdminUi\Tab\TabRegistry $tabRegistry
     * @param \Ibexa\SystemInfo\Tab\SystemInfo\TabFactory $tabFactory
     * @param \Ibexa\Bundle\SystemInfo\SystemInfo\SystemInfoCollectorRegistry $systeminfoCollectorRegistry
     */
    public function __construct(
        TabRegistry $tabRegistry,
        TabFactory $tabFactory,
        SystemInfoCollectorRegistry $systeminfoCollectorRegistry
    ) {
        $this->tabRegistry = $tabRegistry;
        $this->tabFactory = $tabFactory;
        $this->systeminfoCollectorRegistry = $systeminfoCollectorRegistry;
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
