<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace Ibexa\Bundle\SystemInfo\SystemInfo\Value;

use eZ\Publish\API\Repository\Values\ValueObject;

/**
 * Value for information about services used within the project.
 */
final class ServicesSystemInfo extends ValueObject implements SystemInfo
{
    /**
     * Search engine.
     *
     * Example: Solr
     */
    public string $searchEngine;

    /**
     * Reverse proxy handling HTTP caching.
     *
     * Example: Fastly
     */
    public string $httpCacheProxy;

    /**
     * Persistence cache adapter.
     *
     * Example: Redis
     */
    public string $persistenceCacheAdapter;

    public function __construct(
        string $searchEngine,
        string $httpCacheProxy,
        string $persistenceCacheAdapter
    ) {
        $this->searchEngine = $searchEngine;
        $this->httpCacheProxy = $httpCacheProxy;
        $this->persistenceCacheAdapter = $persistenceCacheAdapter;

        parent::__construct([
            'searchEngine' => $searchEngine,
            'httpCacheProxy' => $httpCacheProxy,
            'persistenceCacheAdapter' => $persistenceCacheAdapter,
        ]);
    }
}
