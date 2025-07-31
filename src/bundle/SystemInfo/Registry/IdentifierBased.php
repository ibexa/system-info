<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Bundle\SystemInfo\SystemInfo\Registry;

use Ibexa\Bundle\SystemInfo\SystemInfo\Collector\SystemInfoCollector;
use Ibexa\Bundle\SystemInfo\SystemInfo\SystemInfoCollectorRegistry;
use Ibexa\Core\Base\Exceptions\NotFoundException;

/**
 * A registry of SystemInfoCollectors that uses an identifier string to identify the collector.
 */
final readonly class IdentifierBased implements SystemInfoCollectorRegistry
{
    /**
     * @param \Ibexa\Bundle\SystemInfo\SystemInfo\Collector\SystemInfoCollector[] $registry Hash of SystemInfoCollectors, with identifier string as key.
     */
    public function __construct(private array $registry = [])
    {
    }

    /**
     * @throws \Ibexa\Contracts\Core\Repository\Exceptions\NotFoundException
     */
    public function getItem(string $identifier): SystemInfoCollector
    {
        if (isset($this->registry[$identifier])) {
            return $this->registry[$identifier];
        }

        throw new NotFoundException('A SystemInfo collector could not be found.', $identifier);
    }

    /**
     * @return string[]
     */
    public function getIdentifiers(): array
    {
        return array_keys($this->registry);
    }
}
