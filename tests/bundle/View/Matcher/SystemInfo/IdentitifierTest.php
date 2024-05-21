<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace Ibexa\Tests\Bundle\SystemInfo\View\Matcher\SystemInfo;

use Ibexa\Bundle\SystemInfo\SystemInfo\Value\HardwareSystemInfo;
use Ibexa\Bundle\SystemInfo\View\Matcher\SystemInfo\Identifier;
use Ibexa\Bundle\SystemInfo\View\SystemInfoView;
use Ibexa\Core\MVC\Symfony\View\ContentView;
use PHPUnit\Framework\TestCase;

class IdentitifierTest extends TestCase
{
    public function testMatch()
    {
        $view = new SystemInfoView();
        $view->setInfo(new HardwareSystemInfo());

        $matcher = new Identifier();
        $matcher->setMatchingConfig('hardware');

        self::assertTrue($matcher->match($view));
    }

    public function testNoMatch()
    {
        $view = new SystemInfoView();
        $view->setInfo(new HardwareSystemInfo());

        $matcher = new Identifier();
        $matcher->setMatchingConfig('php');

        self::assertFalse($matcher->match($view));
    }

    public function testMatchOtherView()
    {
        $view = new ContentView();

        $matcher = new Identifier();
        $matcher->setMatchingConfig('test');

        self::assertFalse($matcher->match($view));
    }
}
