<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Tests\Bundle\SystemInfo\SystemInfo\Collector;

use Ibexa\Bundle\SystemInfo\SystemInfo\Collector\IbexaSystemInfoCollector;
use Ibexa\Bundle\SystemInfo\SystemInfo\Collector\JsonComposerLockSystemInfoCollector;
use Ibexa\Bundle\SystemInfo\SystemInfo\Value\IbexaSystemInfo;
use Ibexa\Contracts\Core\Ibexa;
use Ibexa\SystemInfo\VersionStability\VersionStabilityChecker;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class IbexaSystemInfoCollectorTest extends TestCase
{
    private VersionStabilityChecker&MockObject $versionStabilityChecker;

    public function setUp(): void
    {
        $this->versionStabilityChecker = $this->createMock(VersionStabilityChecker::class);
    }

    public function testCollect(): void
    {
        $composerCollector = new JsonComposerLockSystemInfoCollector(
            $this->versionStabilityChecker,
            __DIR__ . '/_fixtures/composer.lock',
            __DIR__ . '/_fixtures/composer.json'
        );

        $systemInfoCollector = new IbexaSystemInfoCollector($composerCollector);

        $systemInfo = $systemInfoCollector->collect();

        self::assertSame(IbexaSystemInfo::PRODUCT_NAME_OSS, $systemInfo->name);
        self::assertSame(Ibexa::VERSION, $systemInfo->release);

        // Test that information from the composer.json file is correctly extracted
        self::assertSame('stable', $systemInfo->lowestStability);
    }

    public function testCollectWithInvalidComposerJson(): void
    {
        $composerCollector = new JsonComposerLockSystemInfoCollector(
            $this->versionStabilityChecker,
            __DIR__ . '/_fixtures/corrupted_composer.lock',
            __DIR__ . '/_fixtures/corrupted_composer.json'
        );

        $systemInfoCollector = new IbexaSystemInfoCollector($composerCollector);

        self::expectNotToPerformAssertions();

        $systemInfoCollector->collect();
    }
}
