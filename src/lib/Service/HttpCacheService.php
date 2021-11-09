<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\SystemInfo\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * @internal
 */
final class HttpCacheService implements Service
{
    private const HTTP_CACHE_CONFIG_KEY = 'purge_type';

    /** @var \Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface */
    private $parameterBag;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->parameterBag = $parameterBag;
    }

    public function getValue(): string
    {
        return $this->parameterBag->get(self::HTTP_CACHE_CONFIG_KEY);
    }
}

class_alias(HttpCacheService::class, 'EzSystems\EzSupportTools\Service\HttpCacheService');
