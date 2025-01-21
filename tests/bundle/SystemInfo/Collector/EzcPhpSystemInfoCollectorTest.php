<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace Ibexa\Tests\Bundle\SystemInfo\SystemInfo\Collector;

use ezcSystemInfoAccelerator;
use Ibexa\Bundle\SystemInfo\SystemInfo\Collector\EzcPhpSystemInfoCollector;
use Ibexa\Bundle\SystemInfo\SystemInfo\EzcSystemInfoWrapper;
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
            ->getMockBuilder(EzcSystemInfoWrapper::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->ezcSystemInfoMock->phpVersion = explode('.', PHP_VERSION);

        $this->ezcSystemInfoMock->phpAccelerator = $this
            ->getMockBuilder(ezcSystemInfoAccelerator::class)
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
    public function testCollect(): void
    {
        $value = $this->ezcPhpCollector->collect();

        self::assertInstanceOf(PhpSystemInfo::class, $value);
        self::assertInstanceOf(ezcSystemInfoAccelerator::class, $this->ezcSystemInfoMock->phpAccelerator);

        self::assertEquals(
            new PhpSystemInfo([
                'version' => implode('.', $this->ezcSystemInfoMock->phpVersion ?? []),
                'acceleratorEnabled' => $this->ezcSystemInfoMock->phpAccelerator->isEnabled,
                'acceleratorName' => $this->ezcSystemInfoMock->phpAccelerator->name,
                'acceleratorURL' => $this->ezcSystemInfoMock->phpAccelerator->url,
                'acceleratorVersion' => $this->ezcSystemInfoMock->phpAccelerator->versionString,
            ]),
            $value
        );
    }
}

class_alias(EzcPhpSystemInfoCollectorTest::class, 'EzSystems\EzSupportToolsBundle\Tests\SystemInfo\Collector\EzcPhpSystemInfoCollectorTest');
