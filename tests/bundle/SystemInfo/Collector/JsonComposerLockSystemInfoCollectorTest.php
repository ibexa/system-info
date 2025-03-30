<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace Ibexa\Tests\Bundle\SystemInfo\SystemInfo\Collector;

use Ibexa\Bundle\SystemInfo\SystemInfo\Collector\JsonComposerLockSystemInfoCollector;
use Ibexa\Bundle\SystemInfo\SystemInfo\Exception\ComposerFileValidationException;
use Ibexa\Bundle\SystemInfo\SystemInfo\Exception\ComposerJsonFileNotFoundException;
use Ibexa\Bundle\SystemInfo\SystemInfo\Exception\ComposerLockFileNotFoundException;
use Ibexa\Bundle\SystemInfo\SystemInfo\Value\ComposerPackage;
use Ibexa\Bundle\SystemInfo\SystemInfo\Value\ComposerSystemInfo;
use Ibexa\SystemInfo\VersionStability\VersionStabilityChecker;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class JsonComposerLockSystemInfoCollectorTest extends TestCase
{
    private VersionStabilityChecker&MockObject $versionStabilityChecker;

    public function setUp(): void
    {
        $this->versionStabilityChecker = $this->createMock(VersionStabilityChecker::class);
    }

    /**
     * @covers \Ibexa\Bundle\SystemInfo\SystemInfo\Collector\JsonComposerLockSystemInfoCollector::collect()
     */
    public function testCollectWithMinimumStability(): void
    {
        $expected = new ComposerSystemInfo([
            'packages' => [
                'ezsystems/ezpublish-kernel' => new ComposerPackage([
                    'name' => 'ezsystems/ezpublish-kernel',
                    'branch' => 'dev-master',
                    'alias' => '7.5.x-dev',
                    'version' => '7.5.x',
                    'license' => 'GPL-2.0',
                    'stability' => 'dev',
                    'dateTime' => new \DateTime('2016-02-28 14:30:53'),
                    'homepage' => 'https://ibexa.co',
                    'reference' => 'ec897baa77c63b745749acf201e85b92bd614723',
                ]),
                'doctrine/dbal' => new ComposerPackage([
                    'name' => 'doctrine/dbal',
                    'branch' => 'v2.5.4',
                     'alias' => null,
                    'version' => '2.5.4',
                    'license' => 'MIT',
                    'dateTime' => new \DateTime('2016-01-05 22:11:12'),
                    'homepage' => 'http://www.doctrine-project.org',
                    'reference' => 'abbdfd1cff43a7b99d027af3be709bc8fc7d4769',
                ]),
                'symfony/symfony' => new ComposerPackage([
                    'name' => 'symfony/symfony',
                    'branch' => 'v2.7.10',
                    'alias' => null,
                    'version' => '2.7.10',
                    'license' => 'MIT',
                    'dateTime' => new \DateTime('2016-02-28 20:37:19'),
                    'homepage' => 'https://symfony.com',
                    'reference' => '9a3b6bf6ebee49370aaf15abc1bdeb4b1986a67d',
                ]),
                'zetacomponents/system-information' => new ComposerPackage([
                    'name' => 'zetacomponents/system-information',
                    'branch' => '1.1',
                    'alias' => null,
                    'version' => '1.1',
                    'license' => 'Apache-2.0',
                    'dateTime' => new \DateTime('2014-09-27 19:26:09'),
                    'homepage' => 'https://github.com/zetacomponents',
                    'reference' => 'be0e5b69dde0a51f8d2a036b891964521939769f',
                ]),
            ],
            'minimumStability' => 'stable',
            'repositoryUrls' => ['https://updates.ibexa.co/bul'],
        ]);

        $composerCollector = new JsonComposerLockSystemInfoCollector(
            $this->versionStabilityChecker,
            __DIR__ . '/_fixtures/composer.lock',
            __DIR__ . '/_fixtures/composer.json'
        );
        $value = $composerCollector->collect();

        self::assertEquals($expected, $value);
    }

    /**
     * @covers \Ibexa\Bundle\SystemInfo\SystemInfo\Collector\JsonComposerLockSystemInfoCollector::collect()
     */
    public function testCollectLockFileNotFound(): void
    {
        $this->expectException(ComposerLockFileNotFoundException::class);

        $composerCollectorNotFound = new JsonComposerLockSystemInfoCollector(
            $this->versionStabilityChecker,
            __DIR__ . '/_fixtures/snafu.lock',
            __DIR__ . '/_fixtures/composer.json'
        );
        $composerCollectorNotFound->collect();
    }

    /**
     * @covers \Ibexa\Bundle\SystemInfo\SystemInfo\Collector\JsonComposerLockSystemInfoCollector::collect()
     */
    public function testCollectJsonFileNotFound(): void
    {
        $this->expectException(ComposerJsonFileNotFoundException::class);

        $composerCollectorNotFound = new JsonComposerLockSystemInfoCollector(
            $this->versionStabilityChecker,
            __DIR__ . '/_fixtures/composer.lock',
            __DIR__ . '/_fixtures/snafu.json'
        );
        $composerCollectorNotFound->collect();
    }

    /**
     * @covers \Ibexa\Bundle\SystemInfo\SystemInfo\Collector\JsonComposerLockSystemInfoCollector::collect()
     */
    public function testCollectLockFileCorrupted(): void
    {
        $composerCollectorCorrupted = new JsonComposerLockSystemInfoCollector(
            $this->versionStabilityChecker,
            __DIR__ . '/_fixtures/corrupted_composer.lock',
            __DIR__ . '/_fixtures/composer.json'
        );

        $this->expectException(ComposerFileValidationException::class);
        $composerCollectorCorrupted->collect();
    }

    /**
     * @covers \Ibexa\Bundle\SystemInfo\SystemInfo\Collector\JsonComposerLockSystemInfoCollector::collect()
     */
    public function testCollectJsonFileCorrupted(): void
    {
        $composerCollectorCorrupted = new JsonComposerLockSystemInfoCollector(
            $this->versionStabilityChecker,
            __DIR__ . '/_fixtures/composer.lock',
            __DIR__ . '/_fixtures/corrupted_composer.json'
        );

        $this->expectException(ComposerFileValidationException::class);
        $composerCollectorCorrupted->collect();
    }
}
