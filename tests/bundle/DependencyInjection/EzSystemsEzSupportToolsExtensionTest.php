<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Tests\Bundle\SystemInfo\DependencyInjection;

use Ibexa\SystemInfo\Storage\AggregateMetricsProvider;
use Ibexa\SystemInfo\Storage\Metrics;
use Ibexa\SystemInfo\Storage\MetricsProvider;
use Ibexa\Bundle\SystemInfo\DependencyInjection\IbexaSystemInfoExtension;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;

class EzSystemsEzSupportToolsExtensionTest extends AbstractExtensionTestCase
{
    protected function getContainerExtensions(): array
    {
        return [new EzSystemsEzSupportToolsExtension()];
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->container->setParameter('kernel.project_dir', dirname(__DIR__) . '/var');
    }

    public function testLoadMetricsServices(): void
    {
        $services = [
            Metrics\PublishedContentObjectsCountMetrics::class => 'published',
            Metrics\UsersCountMetrics::class => 'users',
            Metrics\DraftsCountMetrics::class => 'drafts',
            Metrics\VersionsCountMetrics::class => 'versions',
            Metrics\ContentTypesCountMetrics::class => 'content_types',
        ];

        $this->load([]);

        $this->assertContainerBuilderHasAlias(MetricsProvider::class);
        $this->assertContainerBuilderHasService(AggregateMetricsProvider::class);

        foreach ($services as $serviceId => $identifier) {
            $this->assertContainerBuilderHasServiceDefinitionWithTag(
                $serviceId,
                EzSystemsEzSupportToolsExtension::METRICS_TAG,
                ['identifier' => $identifier]
            );
        }
    }
}

class_alias(EzSystemsEzSupportToolsExtensionTest::class, 'EzSystems\EzSupportToolsBundle\Tests\DependencyInjection\EzSystemsEzSupportToolsExtensionTest');
