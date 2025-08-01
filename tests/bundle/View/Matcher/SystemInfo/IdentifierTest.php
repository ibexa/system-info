<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Tests\Bundle\SystemInfo\View\Matcher\SystemInfo;

use Ibexa\Bundle\SystemInfo\SystemInfo\Value\HardwareSystemInfo;
use Ibexa\Bundle\SystemInfo\View\Matcher\SystemInfo\Identifier;
use Ibexa\Bundle\SystemInfo\View\SystemInfoView;
use Ibexa\Core\MVC\Symfony\View\ContentView;
use PHPUnit\Framework\TestCase;

final class IdentifierTest extends TestCase
{
    public function testMatch(): void
    {
        $view = new SystemInfoView();
        $view->setInfo(new HardwareSystemInfo());

        $matcher = new Identifier();
        $matcher->setMatchingConfig('hardware');

        self::assertTrue($matcher->match($view));
    }

    public function testNoMatch(): void
    {
        $view = new SystemInfoView();
        $view->setInfo(new HardwareSystemInfo());

        $matcher = new Identifier();
        $matcher->setMatchingConfig('php');

        self::assertFalse($matcher->match($view));
    }

    public function testMatchOtherView(): void
    {
        $view = new ContentView();

        $matcher = new Identifier();
        $matcher->setMatchingConfig('test');

        self::assertFalse($matcher->match($view));
    }
}
