<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Bundle\SystemInfo\SystemInfo\Collector;

use Composer\InstalledVersions;
use DateTime;
use Ibexa\Bundle\SystemInfo\SystemInfo\Exception;
use Ibexa\Bundle\SystemInfo\SystemInfo\Value\ComposerPackage;
use Ibexa\Bundle\SystemInfo\SystemInfo\Value\ComposerSystemInfo;
use Ibexa\SystemInfo\Value\Stability;
use Ibexa\SystemInfo\VersionStability\VersionStabilityChecker;

/**
 * Collects information about installed Composer packages, by reading json from composer.lock.
 */
final class JsonComposerLockSystemInfoCollector implements SystemInfoCollector
{
    public const string IBEXA_OSS_PACKAGE = 'ibexa/oss';

    /**
     * The collected value, cached in case info is collected by other collectors.
     */
    private ?ComposerSystemInfo $value = null;

    public function __construct(
        private readonly VersionStabilityChecker $versionStabilityChecker,
        private readonly string $lockFile,
        private readonly string $jsonFile
    ) {
    }

    /**
     * Collects information about installed composer packages.
     *
     * @throws \Ibexa\Bundle\SystemInfo\SystemInfo\Exception\ComposerLockFileNotFoundException if the composer.lock file was not found.
     * @throws \Ibexa\Bundle\SystemInfo\SystemInfo\Exception\ComposerJsonFileNotFoundException if the composer.json file was not found.
     * @throws \Ibexa\Bundle\SystemInfo\SystemInfo\Exception\ComposerFileValidationException if composer.lock of composer.json are not valid.
     */
    public function collect(): ComposerSystemInfo
    {
        if ($this->value) {
            return $this->value;
        }

        if (!file_exists($this->lockFile)) {
            throw new Exception\ComposerLockFileNotFoundException($this->lockFile);
        }

        if (!file_exists($this->jsonFile)) {
            throw new Exception\ComposerJsonFileNotFoundException($this->jsonFile);
        }

        $lockData = json_decode(file_get_contents($this->lockFile) ?: '', true);
        $jsonData = json_decode(file_get_contents($this->jsonFile) ?: '', true);

        if (!is_array($lockData)) {
            throw new Exception\ComposerFileValidationException($this->lockFile);
        }

        if (!is_array($jsonData)) {
            throw new Exception\ComposerFileValidationException($this->jsonFile);
        }

        $stability = InstalledVersions::isInstalled(self::IBEXA_OSS_PACKAGE)
            ? $this->versionStabilityChecker->getStability(
                InstalledVersions::getVersion(self::IBEXA_OSS_PACKAGE) ?? ''
            )
            : $this->getMinimumStability($lockData);

        return $this->value = new ComposerSystemInfo([
            'packages' => $this->extractPackages($lockData),
            'repositoryUrls' => $this->extractRepositoryUrls($jsonData),
            'minimumStability' => $stability,
        ]);
    }

    /**
     * @param array<string, mixed> $lockData
     *
     * @return \Ibexa\Bundle\SystemInfo\SystemInfo\Value\ComposerPackage[]
     */
    private function extractPackages(array $lockData): array
    {
        $packages = [];
        $rootAliases = [];
        foreach ($lockData['aliases'] as $alias) {
            $rootAliases[$alias['package']] = $alias['alias'];
        }

        foreach ($lockData['packages'] as $packageData) {
            $package = new ComposerPackage([
                'name' => $packageData['name'],
                'branch' => $packageData['version'],
                'dateTime' => isset($packageData['time']) ? new DateTime($packageData['time']) : null,
                'homepage' => $packageData['homepage'] ?? '',
                'reference' => isset($packageData['source']) ? $packageData['source']['reference'] : null,
                'license' => $packageData['license'][0] ?? null,
            ]);

            if (isset($lockData['stability-flags'][$package->name])) {
                $stabilityFlag = (int)$lockData['stability-flags'][$package->name];

                $package->stability = Stability::STABILITIES[$stabilityFlag] ?? null;
            } else {
                $package->stability = null;
            }

            if (isset($rootAliases[$package->name])) {
                $package->alias = $rootAliases[$package->name];
            } elseif (isset($packageData['extra']['branch-alias'][$package->branch])) {
                $package->alias = $packageData['extra']['branch-alias'][$package->branch];
            }

            self::setNormalizedVersion($package);

            $packages[$packageData['name']] = $package;
        }

        ksort($packages, SORT_FLAG_CASE | SORT_STRING);

        return $packages;
    }

    /**
     * @param array<string, mixed> $jsonData
     *
     * @return string[]
     */
    private function extractRepositoryUrls(array $jsonData): array
    {
        $repos = [];
        if (!isset($jsonData['repositories'])) {
            return $repos;
        }

        foreach ($jsonData['repositories'] as $composerRepository) {
            if (empty($composerRepository['type']) || $composerRepository['type'] !== 'composer') {
                continue;
            }

            if (empty($composerRepository['url'])) {
                continue;
            }

            $repos[] = $composerRepository['url'];
        }

        return $repos;
    }

    private static function setNormalizedVersion(ComposerPackage $package): void
    {
        $version = $package->alias ?: $package->branch;
        if ($version[0] === 'v') {
            $version = substr($version, 1);
        }

        if (strpos($version, 'x-dev')) {
            $version = str_replace('-dev', '', $version);
            $package->stability = 'dev';
        }

        $package->version = $version;
    }

    /**
     * @param array<string, mixed> $lockData
     */
    private function getMinimumStability(array $lockData): ?string
    {
        return $lockData['minimum-stability'] ?? null;
    }
}
