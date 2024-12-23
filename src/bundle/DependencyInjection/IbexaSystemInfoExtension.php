<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Bundle\SystemInfo\DependencyInjection;

use Composer\InstalledVersions;
use Ibexa\Bundle\SystemInfo\SystemInfo\Collector\IbexaSystemInfoCollector;
use Ibexa\Bundle\SystemInfo\SystemInfo\Value\IbexaSystemInfo;
use Ibexa\Contracts\Core\Ibexa;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class IbexaSystemInfoExtension extends Extension implements PrependExtensionInterface
{
    public const EXTENSION_NAME = 'ibexa_system_info';
    public const METRICS_TAG = 'ibexa.system_info.metrics';
    public const SERVICE_TAG = 'ibexa.system_info.service';

    public function getAlias()
    {
        return self::EXTENSION_NAME;
    }

    public function getConfiguration(array $config, ContainerBuilder $container): Configuration
    {
        return new Configuration();
    }

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new Loader\YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config')
        );

        $loader->load('services.yaml');
        $loader->load('default_settings.yaml');

        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        if (isset($config['system_info']) && $config['system_info']['powered_by']['enabled']) {
            $container->setParameter(
                'ibexa.system_info.powered_by.name',
                $this->getPoweredByName(
                    $container,
                    $config['system_info']['powered_by']['release']
                )
            );
        }
    }

    public function prepend(ContainerBuilder $container): void
    {
        $this->prependJMSTranslation($container);
    }

    private function getPoweredByName(ContainerBuilder $container, ?string $release): string
    {
        $vendor = $container->getParameter('kernel.project_dir') . '/vendor/';

        // Autodetect product name
        $name = self::getNameByPackages($vendor);

        if ($release === 'major') {
            $name .= ' v' . (int)Ibexa::VERSION;
        } elseif ($release === 'minor') {
            $version = explode('.', Ibexa::VERSION);
            $name .= ' v' . $version[0] . '.' . $version[1];
        }

        return $name;
    }

    private function prependJMSTranslation(ContainerBuilder $container): void
    {
        $container->prependExtensionConfig('jms_translation', [
            'configs' => [
                self::EXTENSION_NAME => [
                    'dirs' => [
                        __DIR__ . '/../../../src/',
                    ],
                    'output_dir' => __DIR__ . '/../Resources/translations/',
                    'output_format' => 'xliff',
                    'excluded_dirs' => ['Behat', 'Tests', 'node_modules'],
                ],
            ],
        ]);
    }

    public static function getEditionByPackages(): string
    {
        if (InstalledVersions::isInstalled(IbexaSystemInfoCollector::COMMERCE_PACKAGES[0])) {
            return 'commerce';
        } elseif (InstalledVersions::isInstalled(IbexaSystemInfoCollector::EXPERIENCE_PACKAGES[0])) {
            return 'experience';
        } elseif (InstalledVersions::isInstalled(IbexaSystemInfoCollector::HEADLESS_PACKAGES[0])) {
            return 'headless';
        }

        return 'oss';
    }

    public static function getNameByPackages(string $vendor = null): string
    {
        return IbexaSystemInfo::PRODUCT_NAME_VARIANTS[self::getEditionByPackages()];
    }
}

class_alias(IbexaSystemInfoExtension::class, 'EzSystems\EzSupportToolsBundle\DependencyInjection\EzSystemsEzSupportToolsExtension');
