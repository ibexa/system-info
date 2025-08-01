<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Bundle\SystemInfo\SystemInfo\Collector;

use Ibexa\Bundle\SystemInfo\SystemInfo\Value\SymfonyKernelSystemInfo;
use Symfony\Component\HttpKernel\Kernel;

/**
 * Collects information about the Symfony kernel we are using.
 */
final class ConfigurationSymfonyKernelSystemInfoCollector implements SystemInfoCollector
{
    /**
     * Installed bundles.
     *
     * A hash containing the active bundles, where the key is the bundle name, and the value is the corresponding namespace.
     *
     * Example:
     * array (
     *   'AppBundle' => 'AppBundle\\AppBundle',
     *   'AsseticBundle' => 'Symfony\\Bundle\\AsseticBundle\\AsseticBundle',
     * )
     *
     * @param array<string, class-string> $bundles
     */
    public function __construct(
        private readonly Kernel $kernel,
        private array $bundles
    ) {
    }

    public function collect(): SymfonyKernelSystemInfo
    {
        ksort($this->bundles, SORT_FLAG_CASE | SORT_STRING);

        return new SymfonyKernelSystemInfo([
            'environment' => $this->kernel->getEnvironment(),
            'debugMode' => $this->kernel->isDebug(),
            'version' => Kernel::VERSION,
            'bundles' => $this->bundles,
            'projectDir' => $this->kernel->getProjectdir(),
            'cacheDir' => $this->kernel->getCacheDir(),
            'logDir' => $this->kernel->getLogDir(),
            'charset' => $this->kernel->getCharset(),
        ]);
    }
}
