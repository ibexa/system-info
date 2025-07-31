<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Tests\Bundle\SystemInfo\SystemInfo\Collector;

use Ibexa\Bundle\SystemInfo\SystemInfo\Collector\HardwareSystemInfoCollector;
use Ibexa\Bundle\SystemInfo\SystemInfo\SystemInfoWrapper;
use Ibexa\Bundle\SystemInfo\SystemInfo\Value\HardwareSystemInfo;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class HardwareSystemInfoCollectorTest extends TestCase
{
    private SystemInfoWrapper&MockObject $systemInfoMock;

    private HardwareSystemInfoCollector $ezcHardware;

    protected function setUp(): void
    {
        $this->systemInfoMock = $this
            ->getMockBuilder(SystemInfoWrapper::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->systemInfoMock->cpuType = 'Intel(R) Core(TM) i7-3720QM CPU @ 2.60GHz';
        $this->systemInfoMock->cpuSpeed = 2591.9000000000001;
        $this->systemInfoMock->cpuCount = 1;
        $this->systemInfoMock->memorySize = 1554632704;

        $this->ezcHardware = new HardwareSystemInfoCollector($this->systemInfoMock);
    }

    /**
     * @covers \Ibexa\Bundle\SystemInfo\SystemInfo\Collector\EzcHardwareSystemInfoCollector::collect()
     */
    public function testCollect(): void
    {
        $value = $this->ezcHardware->collect();

        self::assertEquals(
            new HardwareSystemInfo([
                'cpuType' => $this->systemInfoMock->cpuType,
                'cpuSpeed' => $this->systemInfoMock->cpuSpeed,
                'cpuCount' => $this->systemInfoMock->cpuCount,
                'memorySize' => $this->systemInfoMock->memorySize,
            ]),
            $value
        );
    }
}
