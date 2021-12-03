<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Tests\Bundle\SystemInfo\DependencyInjection;

use Ibexa\Bundle\SystemInfo\DependencyInjection\IbexaSystemInfoExtension;
use Ibexa\SystemInfo\Service;
use Ibexa\SystemInfo\Service\AggregateServiceProvider;
use Ibexa\SystemInfo\Service\ServiceProviderInterface;
use Ibexa\SystemInfo\Storage\AggregateMetricsProvider;
use Ibexa\SystemInfo\Storage\Metrics;
use Ibexa\SystemInfo\Storage\MetricsProvider;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;

class IbexaSystemInfoExtensionTest extends AbstractExtensionTestCase
{
    protected function getContainerExtensions(): array
    {
        return [new IbexaSystemInfoExtension()];
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
                IbexaSystemInfoExtension::METRICS_TAG,
                ['identifier' => $identifier]
            );
        }
    }

    public function testLoadServiceServices(): void
    {
        $services = [
            Service\SearchEngineServiceInfo::class => 'searchEngine',
            Service\HttpCacheServiceInfo::class => 'httpCacheProxy',
            Service\PersistenceCacheServiceInfo::class => 'persistenceCacheAdapter',
        ];

        $this->load([]);

        $this->assertContainerBuilderHasAlias(ServiceProviderInterface::class);
        $this->assertContainerBuilderHasService(AggregateServiceProvider::class);

        foreach ($services as $serviceId => $identifier) {
            $this->assertContainerBuilderHasServiceDefinitionWithTag(
                $serviceId,
                IbexaSystemInfoExtension::SERVICE_TAG,
                ['identifier' => $identifier]
            );
        }
    }
}

class_alias(IbexaSystemInfoExtensionTest::class, 'EzSystems\EzSupportToolsBundle\Tests\DependencyInjection\EzSystemsEzSupportToolsExtensionTest');
