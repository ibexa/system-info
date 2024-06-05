<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace Ibexa\Tests\Bundle\SystemInfo\SystemInfo\Collector;

use Ibexa\Bundle\SystemInfo\SystemInfo\Collector\EzcPhpSystemInfoCollector;
use Ibexa\Bundle\SystemInfo\SystemInfo\Value\PhpSystemInfo;
use PHPUnit\Framework\TestCase;

class EzcPhpSystemInfoCollectorTest extends TestCase
{
    /**
     * @var \Ibexa\Bundle\SystemInfo\SystemInfo\EzcSystemInfoWrapper|\PHPUnit\Framework\MockObject\MockObject
     */
    private $ezcSystemInfoMock;

    /**
     * @var \Ibexa\Bundle\SystemInfo\SystemInfo\Collector\EzcPhpSystemInfoCollector
     */
    private $ezcPhpCollector;

    protected function setUp(): void
    {
        $this->ezcSystemInfoMock = $this
            ->getMockBuilder('Ibexa\\Bundle\\SystemInfo\\SystemInfo\\EzcSystemInfoWrapper')
            ->disableOriginalConstructor()
            ->getMock();
        $this->ezcSystemInfoMock->phpVersion = PHP_VERSION;

        $this->ezcSystemInfoMock->phpAccelerator = $this
            ->getMockBuilder('ezcSystemInfoAccelerator')
            ->setConstructorArgs(
                [
                    'Zend OPcache',
                    'http://www.php.net/opcache',
                    true,
                    false,
                    '7.0.4-devFE',
                ]
            )
            ->getMock();

        $this->ezcPhpCollector = new EzcPhpSystemInfoCollector($this->ezcSystemInfoMock);
    }

    /**
     * @covers \Ibexa\Bundle\SystemInfo\SystemInfo\Collector\EzcPhpSystemInfoCollector::collect()
     */
    public function testCollect()
    {
        $value = $this->ezcPhpCollector->collect();

        self::assertInstanceOf('Ibexa\\Bundle\\SystemInfo\\SystemInfo\\Value\\PhpSystemInfo', $value);

        self::assertEquals(
            new PhpSystemInfo([
                'version' => $this->ezcSystemInfoMock->phpVersion,
                'acceleratorEnabled' => $this->ezcSystemInfoMock->phpAccelerator->isEnabled,
                'acceleratorName' => $this->ezcSystemInfoMock->phpAccelerator->name,
                'acceleratorURL' => $this->ezcSystemInfoMock->phpAccelerator->url,
                'acceleratorVersion' => $this->ezcSystemInfoMock->phpAccelerator->versionString,
            ]),
            $value
        );
    }
}
