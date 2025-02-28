<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace Ibexa\Bundle\SystemInfo\SystemInfo\Value;

/**
 * Value for information about services used within the project.
 */
final class ServicesSystemInfo implements SystemInfo
{
    public function __construct(
        /**
         * Search engine.
         *
         * Example: Solr
         */
        private string $searchEngine,
        /**
         * Reverse proxy handling HTTP caching.
         *
         * Example: Fastly
         */
        private string $httpCacheProxy,
        /**
         * Persistence cache adapter.
         *
         * Example: Redis
         */
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
