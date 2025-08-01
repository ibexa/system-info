<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Tests\Bundle\SystemInfo\SystemInfo\Collector;

use ezcSystemInfoAccelerator;
use Ibexa\Bundle\SystemInfo\SystemInfo\Collector\PhpSystemInfoCollector;
use Ibexa\Bundle\SystemInfo\SystemInfo\SystemInfoWrapper;
use Ibexa\Bundle\SystemInfo\SystemInfo\Value\PhpSystemInfo;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class PhpSystemInfoCollectorTest extends TestCase
{
    private SystemInfoWrapper&MockObject $systemInfoMock;

    private PhpSystemInfoCollector $phpCollector;

    protected function setUp(): void
    {
        $this->systemInfoMock = $this
            ->getMockBuilder(SystemInfoWrapper::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->systemInfoMock->phpVersion = explode('.', PHP_VERSION);

        $this->systemInfoMock->phpAccelerator = $this
            ->getMockBuilder(ezcSystemInfoAccelerator::class)
            ->setConstructorArgs(
                [
                    'Zend OPcache',
                    'https://www.php.net/opcache',
                    true,
                    false,
                    '7.0.4-devFE',
                ]
            )
            ->getMock();

        $this->phpCollector = new PhpSystemInfoCollector($this->systemInfoMock);
    }

    /**
     * @covers \Ibexa\Bundle\SystemInfo\SystemInfo\Collector\EzcPhpSystemInfoCollector::collect()
     */
    public function testCollect(): void
    {
        $value = $this->phpCollector->collect();

        self::assertInstanceOf(
            ezcSystemInfoAccelerator::class,
            $this->systemInfoMock->phpAccelerator
        );

        self::assertEquals(
            new PhpSystemInfo([
                'version' => implode('.', $this->systemInfoMock->phpVersion ?? []),
                'acceleratorEnabled' => $this->systemInfoMock->phpAccelerator->isEnabled,
                'acceleratorName' => $this->systemInfoMock->phpAccelerator->name,
                'acceleratorURL' => $this->systemInfoMock->phpAccelerator->url,
                'acceleratorVersion' => $this->systemInfoMock->phpAccelerator->versionString,
            ]),
            $value
        );
    }
}
