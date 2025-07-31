<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Tests\Bundle\SystemInfo\SystemInfo\Collector;

use Ibexa\Bundle\SystemInfo\SystemInfo\Collector\ConfigurationSymfonyKernelSystemInfoCollector;
use Ibexa\Bundle\SystemInfo\SystemInfo\Value\SymfonyKernelSystemInfo;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Kernel;

final class ConfigurationSymfonyKernelSystemInfoCollectorTest extends TestCase
{
    /**
     * @covers \Ibexa\Bundle\SystemInfo\SystemInfo\Collector\ConfigurationSymfonyKernelSystemInfoCollector::collect()
     */
    public function testCollect(): void
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

        $kernelMock = $this->getMockBuilder(Kernel::class)
            ->setConstructorArgs([
                $expected->environment,
                $expected->debugMode,
            ])
            ->getMock();

        $kernelMock
            ->expects(self::once())
            ->method('getEnvironment')
            ->willReturn($expected->environment);

        $kernelMock
            ->expects(self::once())
            ->method('isDebug')
            ->willReturn($expected->debugMode);

        $kernelMock
            ->expects(self::once())
            ->method('getProjectDir')
            ->willReturn($expected->projectDir);

        $kernelMock
            ->expects(self::once())
            ->method('getCacheDir')
            ->willReturn($expected->cacheDir);

        $kernelMock
            ->expects(self::once())
            ->method('getLogDir')
            ->willReturn($expected->logDir);

        $kernelMock
            ->expects(self::once())
            ->method('getCharset')
            ->willReturn($expected->charset);

        $symfonyCollector = new ConfigurationSymfonyKernelSystemInfoCollector(
            $kernelMock,
            $expected->bundles
        );

        $value = $symfonyCollector->collect();

        self::assertEquals($expected, $value);
    }
}
