<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\SystemInfo\Service;

use Ibexa\Contracts\Core\Container\ApiLoader\RepositoryConfigurationProviderInterface;

/**
 * @internal
 */
final class SearchEngineServiceInfo implements ServiceInfo
{
    private const string SEARCH_KEY = 'search';
    private const string ENGINE_KEY = 'engine';

    public function __construct(private readonly RepositoryConfigurationProviderInterface $repositoryConfigProvider)
    {
    }

    public function getServiceType(): string
    {
        $repositoryConfig = $this->repositoryConfigProvider->getRepositoryConfig();

        return $repositoryConfig[self::SEARCH_KEY][self::ENGINE_KEY];
    }
}
