<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\SystemInfo\Service;

use eZ\Bundle\EzPublishCoreBundle\ApiLoader\RepositoryConfigurationProvider;

/**
 * @internal
 */
final class SearchEngineService implements Service
{
    private const SEARCH_KEY = 'search';
    private const ENGINE_KEY = 'engine';

    /** @var \eZ\Bundle\EzPublishCoreBundle\ApiLoader\RepositoryConfigurationProvider */
    private $repositoryConfigProvider;

    public function __construct(RepositoryConfigurationProvider $repositoryConfigProvider)
    {
        $this->repositoryConfigProvider = $repositoryConfigProvider;
    }

    public function getValue(): string
    {
        $repositoryConfig = $this->repositoryConfigProvider->getRepositoryConfig();

        return $repositoryConfig[self::SEARCH_KEY][self::ENGINE_KEY];
    }
}

class_alias(PersistenceCacheService::class, 'EzSystems\EzSupportTools\Service\SearchEngineService');
