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
            ->expects($this->once())
            ->method('getEnvironment')
            ->will($this->returnValue($expected->environment));

        $kernelMock
            ->expects($this->once())
            ->method('isDebug')
            ->will($this->returnValue($expected->debugMode));

        $kernelMock
            ->expects($this->once())
            ->method('getProjectDir')
            ->will($this->returnValue($expected->projectDir));

        $kernelMock
            ->expects($this->once())
            ->method('getCacheDir')
            ->will($this->returnValue($expected->cacheDir));

        $kernelMock
            ->expects($this->once())
            ->method('getLogDir')
            ->will($this->returnValue($expected->logDir));

        $kernelMock
            ->expects($this->once())
            ->method('getCharset')
            ->will($this->returnValue($expected->charset));

        $symfonyCollector = new ConfigurationSymfonyKernelSystemInfoCollector(
            $kernelMock,
            $expected->bundles
        );

        $value = $symfonyCollector->collect();

        self::assertInstanceOf('Ibexa\\Bundle\\SystemInfo\\SystemInfo\\Value\\SymfonyKernelSystemInfo', $value);

        self::assertEquals($expected, $value);
    }
}

class_alias(ConfigurationSymfonyKernelSystemInfoCollectorTest::class, 'EzSystems\EzSupportToolsBundle\Tests\SystemInfo\Collector\ConfigurationSymfonyKernelSystemInfoCollectorTest');
