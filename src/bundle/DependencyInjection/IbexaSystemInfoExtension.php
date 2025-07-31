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
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;

final class IbexaSystemInfoExtension extends Extension implements PrependExtensionInterface
{
    public const string EXTENSION_NAME = 'ibexa_system_info';
    public const string METRICS_TAG = 'ibexa.system_info.metrics';
    public const string SERVICE_TAG = 'ibexa.system_info.service';

    public function getAlias(): string
    {
        return self::EXTENSION_NAME;
    }

    /**
     * @param array<string, mixed> $config
     */
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
                    $config['system_info']['powered_by']['release']
                )
            );
        }
    }

    public function prepend(ContainerBuilder $container): void
    {
        $this->prependJMSTranslation($container);
    }

    private function getPoweredByName(?string $release): string
    {
        // Autodetect product name
        $name = self::getNameByPackages();

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

    public static function getNameByPackages(): string
    {
        return IbexaSystemInfo::PRODUCT_NAME_VARIANTS[
            self::getEditionByPackages()
        ];
    }
}
