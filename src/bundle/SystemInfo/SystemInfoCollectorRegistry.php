<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace Ibexa\Bundle\SystemInfo\SystemInfo;

/**
 * A registry of SystemInfoCollectors.
 */
interface SystemInfoCollectorRegistry
{
    /**
     * @param \Ibexa\Bundle\SystemInfo\SystemInfo\Collector\SystemInfoCollector[] $items Hash of SystemInfoCollectors, with identifier string as key.
     */
    public function __construct(array $items = []);

    /**
     * Returns the SystemInfoCollector matching the argument.
     *
     * @param string $identifier An identifier string.
     *
     * @throws \Ibexa\Core\Base\Exceptions\NotFoundException If no SystemInfoCollector exists with this identifier
     *
     * @return \Ibexa\Bundle\SystemInfo\SystemInfo\Collector\SystemInfoCollector The SystemInfoCollector given by the identifier.
     */
    public function getItem($identifier);

    /**
     * Returns the identifiers of all registered SystemInfoCollectors.
     *
     * @return string[] Array of identifier strings.
     */
    public function getIdentifiers();
}

class_alias(SystemInfoCollectorRegistry::class, 'EzSystems\EzSupportToolsBundle\SystemInfo\SystemInfoCollectorRegistry');
