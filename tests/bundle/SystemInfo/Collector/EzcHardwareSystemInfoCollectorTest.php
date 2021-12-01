<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace Ibexa\Tests\Bundle\SystemInfo\SystemInfo\Collector;

use Ibexa\Bundle\SystemInfo\SystemInfo\Collector\EzcHardwareSystemInfoCollector;
use Ibexa\Bundle\SystemInfo\SystemInfo\Value\HardwareSystemInfo;
use PHPUnit\Framework\TestCase;

class EzcHardwareSystemInfoCollectorTest extends TestCase
{
    /**
     * @var \Ibexa\Bundle\SystemInfo\SystemInfo\EzcSystemInfoWrapper|\PHPUnit\Framework\MockObject\MockObject
     */
    private $ezcSystemInfoMock;

    /**
     * @var \Ibexa\Bundle\SystemInfo\SystemInfo\Collector\EzcHardwareSystemInfoCollector
     */
    private $ezcHardware;

    protected function setUp(): void
    {
        $this->ezcSystemInfoMock = $this
            ->getMockBuilder('EzSystems\EzSupportToolsBundle\SystemInfo\EzcSystemInfoWrapper')
            ->disableOriginalConstructor()
            ->getMock();
        $this->ezcSystemInfoMock->cpuType = 'Intel(R) Core(TM) i7-3720QM CPU @ 2.60GHz';
        $this->ezcSystemInfoMock->cpuSpeed = '2591.9000000000001';
        $this->ezcSystemInfoMock->cpuCount = '1';
        $this->ezcSystemInfoMock->memorySize = '1554632704';

        $this->ezcHardware = new EzcHardwareSystemInfoCollector($this->ezcSystemInfoMock);
    }

    /**
     * @covers \EzSystems\EzSupportToolsBundle\SystemInfo\Collector\EzcHardwareSystemInfoCollector::collect()
     */
    public function testCollect()
    {
        $value = $this->ezcHardware->collect();

        self::assertInstanceOf('EzSystems\EzSupportToolsBundle\SystemInfo\Value\HardwareSystemInfo', $value);

        self::assertEquals(
            new HardwareSystemInfo([
                'cpuType' => $this->ezcSystemInfoMock->cpuType,
                'cpuSpeed' => $this->ezcSystemInfoMock->cpuSpeed,
                'cpuCount' => $this->ezcSystemInfoMock->cpuCount,
                'memorySize' => $this->ezcSystemInfoMock->memorySize,
            ]),
            $value
        );
    }
}

class_alias(EzcHardwareSystemInfoCollectorTest::class, 'EzSystems\EzSupportToolsBundle\Tests\SystemInfo\Collector\EzcHardwareSystemInfoCollectorTest');
