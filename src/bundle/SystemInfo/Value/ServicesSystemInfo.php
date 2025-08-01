<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Bundle\SystemInfo\SystemInfo\Value;

/**
 * Value for information about services used within the project.
 */
final readonly class ServicesSystemInfo implements SystemInfo
{
    public function __construct(
        private string $searchEngine,
        private string $httpCacheProxy,
        private string $persistenceCacheAdapter
    ) {
    }

    public function getSearchEngine(): string
    {
        return $this->searchEngine;
    }

    public function getHttpCacheProxy(): string
    {
        return $this->httpCacheProxy;
    }

    public function getPersistenceCacheAdapter(): string
    {
        return $this->persistenceCacheAdapter;
    }
}
