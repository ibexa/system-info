<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace Ibexa\Tests\Bundle\SystemInfo\SystemInfo\Collector;

use Ibexa\Bundle\SystemInfo\SystemInfo\Collector\ConfigurationSymfonyKernelSystemInfoCollector;
use Ibexa\Bundle\SystemInfo\SystemInfo\Value\SymfonyKernelSystemInfo;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Kernel;

class ConfigurationSymfonyKernelSystemInfoCollectorTest extends TestCase
{
    /**
     * @covers \Ibexa\Bundle\SystemInfo\SystemInfo\Collector\ConfigurationSymfonyKernelSystemInfoCollector::collect()
     */
    public function testCollect()
    {
        $expected = new SymfonyKernelSystemInfo([
            'environment' => 'dev',
            'debugMode' => true,
            'version' => Kernel::VERSION,
            'bundles' => [
                'AppBundle' => 'AppBundle\\AppBundle',
                'DoctrineBundle' => 'Doctrine\\Bundle\\DoctrineBundle\\DoctrineBundle',
                'IbexaCoreBundle' => 'Ibexa\\Bundle\\Core\\IbexaCoreBundle',
                'IbexaSupportToolsBundle' => 'Ibexa\\Bundle\\SystemInfo\\IbexaSystemInfoBundle',
            ],
            'projectDir' => '/srv/www/ibexa-dxp/app',
            'cacheDir' => '/srv/www/ibexa-dxp/app/cache/prod',
            'logDir' => '/srv/www/ibexa-dxp/app/logs',
            'charset' => 'UTF-8',
        ]);

        $kernelMock = $this->getMockBuilder('Symfony\Component\HttpKernel\Kernel')
            ->setConstructorArgs([$expected->environment, $expected->debugMode])
            ->getMock();

        $kernelMock
            ->expects(self::once())
            ->method('getEnvironment')
            ->will(self::returnValue($expected->environment));

        $kernelMock
            ->expects(self::once())
            ->method('isDebug')
            ->will(self::returnValue($expected->debugMode));

        $kernelMock
            ->expects(self::once())
            ->method('getProjectDir')
            ->will(self::returnValue($expected->projectDir));

        $kernelMock
            ->expects(self::once())
            ->method('getCacheDir')
            ->will(self::returnValue($expected->cacheDir));

        $kernelMock
            ->expects(self::once())
            ->method('getLogDir')
            ->will(self::returnValue($expected->logDir));

        $kernelMock
            ->expects(self::once())
            ->method('getCharset')
            ->will(self::returnValue($expected->charset));

        $symfonyCollector = new ConfigurationSymfonyKernelSystemInfoCollector(
            $kernelMock,
            $expected->bundles
        );

        $value = $symfonyCollector->collect();

        self::assertInstanceOf('Ibexa\\Bundle\\SystemInfo\\SystemInfo\\Value\\SymfonyKernelSystemInfo', $value);

        self::assertEquals($expected, $value);
    }
}
