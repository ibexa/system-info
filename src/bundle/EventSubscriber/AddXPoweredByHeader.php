<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Bundle\SystemInfo\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Sets X-Powered-By header to promote use of Platform.
 */
readonly class AddXPoweredByHeader implements EventSubscriberInterface
{
    public function __construct(private string $installationName)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::RESPONSE => 'promotePlatform'];
    }

    public function promotePlatform(ResponseEvent $event): void
    {
        $response = $event->getResponse();
        if ($response->headers->has('X-Powered-By')) {
            return;
        }

        if ($this->installationName) {
            $response->headers->set('X-Powered-By', $this->installationName);
        }
    }
}
