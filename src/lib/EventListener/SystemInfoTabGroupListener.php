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
    /** @var \Ibexa\AdminUi\Tab\TabRegistry */
    protected $tabRegistry;

    /** @var \Ibexa\SystemInfo\Tab\SystemInfo\TabFactory */
    protected $tabFactory;

    /** @var \Ibexa\Bundle\SystemInfo\SystemInfo\SystemInfoCollectorRegistry */
    protected $systeminfoCollectorRegistry;

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

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            TabEvents::TAB_GROUP_PRE_RENDER => ['onTabGroupPreRender', 10],
        ];
    }

    /**
     * @param \Ibexa\AdminUi\Tab\Event\TabGroupEvent $event
     */
    public function onTabGroupPreRender(TabGroupEvent $event)
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

class_alias(SystemInfoTabGroupListener::class, 'EzSystems\EzSupportTools\EventListener\SystemInfoTabGroupListener');
