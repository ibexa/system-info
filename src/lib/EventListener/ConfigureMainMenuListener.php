<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\SystemInfo\EventListener;

use Ibexa\AdminUi\Menu\Event\ConfigureMenuEvent;
use Ibexa\AdminUi\Menu\MainMenuBuilder;
use Ibexa\Contracts\AdminUi\Menu\MenuItemFactoryInterface;
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use JMS\TranslationBundle\Model\Message;
use JMS\TranslationBundle\Translation\TranslationContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final readonly class ConfigureMainMenuListener implements EventSubscriberInterface, TranslationContainerInterface
{
    public const string ITEM_ADMIN__SYSTEMINFO = 'main__admin__systeminfo';

    public function __construct(
        private MenuItemFactoryInterface $menuItemFactory,
        private PermissionResolver $permissionResolver
    ) {
    }

    public function onMenuConfigure(ConfigureMenuEvent $event): void
    {
        $menu = $event->getMenu();

        if (!$this->permissionResolver->hasAccess('setup', 'system_info')) {
            return;
        }

        $adminMenu = $menu->getChild(MainMenuBuilder::ITEM_ADMIN);
        if ($adminMenu === null) {
            return;
        }

        $adminMenu->addChild(
            $this->menuItemFactory->createItem(
                self::ITEM_ADMIN__SYSTEMINFO,
                [
                    'route' => 'ibexa.systeminfo',
                    'extras' => [
                        'orderNumber' => 80,
                    ],
                ],
            )
        );
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ConfigureMenuEvent::MAIN_MENU => 'onMenuConfigure',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function getTranslationMessages(): array
    {
        return [
            (new Message(self::ITEM_ADMIN__SYSTEMINFO, 'ibexa_menu'))->setDesc('System information'),
        ];
    }
}
