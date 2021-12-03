<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\SystemInfo\Service;

use Ibexa\Bundle\Core\ApiLoader\RepositoryConfigurationProvider;

/**
 * @internal
 */
final class SearchEngineServiceInfo implements ServiceInfo
{
    private const SEARCH_KEY = 'search';
    private const ENGINE_KEY = 'engine';

    private RepositoryConfigurationProvider $repositoryConfigProvider;

    public function __construct(RepositoryConfigurationProvider $repositoryConfigProvider)
    {
        $this->repositoryConfigProvider = $repositoryConfigProvider;
    }

    public function getServiceType(): string
    {
        $repositoryConfig = $this->repositoryConfigProvider->getRepositoryConfig();

        return $repositoryConfig[self::SEARCH_KEY][self::ENGINE_KEY];
    }
}
