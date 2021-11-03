<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace Ibexa\SystemInfo\EventListener;

use EzSystems\EzPlatformAdminUi\Tab\Event\TabEvents;
use EzSystems\EzPlatformAdminUi\Tab\Event\TabGroupEvent;
use Ibexa\SystemInfo\Tab\SystemInfo\TabFactory;
use EzSystems\EzPlatformAdminUi\Tab\TabRegistry;
use Ibexa\Bundle\SystemInfo\SystemInfo\SystemInfoCollectorRegistry;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class SystemInfoTabGroupListener implements EventSubscriberInterface
{
    /** @var TabRegistry */
    protected $tabRegistry;

    /** @var TabFactory */
    protected $tabFactory;

    /** @var SystemInfoCollectorRegistry */
    protected $systeminfoCollectorRegistry;

    /**
     * @param TabRegistry $tabRegistry
     * @param TabFactory $tabFactory
     * @param SystemInfoCollectorRegistry $systeminfoCollectorRegistry
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
     * @param TabGroupEvent $event
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
