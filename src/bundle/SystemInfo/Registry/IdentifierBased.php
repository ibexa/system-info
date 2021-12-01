<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace Ibexa\Bundle\SystemInfo\SystemInfo\Registry;

use Ibexa\Core\Base\Exceptions\NotFoundException;
use Ibexa\Bundle\SystemInfo\SystemInfo\SystemInfoCollectorRegistry;

/**
 * A registry of SystemInfoCollectors that uses an identifier string to identify the collector.
 */
class IdentifierBased implements SystemInfoCollectorRegistry
{
    /** @var \Ibexa\Bundle\SystemInfo\SystemInfo\Collector\SystemInfoCollector[] */
    private $registry = [];

    /**
     * @param \Ibexa\Bundle\SystemInfo\SystemInfo\Collector\SystemInfoCollector[] $items Hash of SystemInfoCollectors, with identifier string as key.
     */
    public function __construct(array $items = [])
    {
        $this->registry = $items;
    }

    /**
     * Returns the SystemInfoCollector matching the argument.
     *
     * @param string $identifier An identifier string.
     *
     * @throws \Ibexa\Core\Base\Exceptions\NotFoundException If no SystemInfoCollector exists with this identifier
     *
     * @return \Ibexa\Bundle\SystemInfo\SystemInfo\Collector\SystemInfoCollector The SystemInfoCollector given by the identifier.
     */
    public function getItem($identifier)
    {
        if (isset($this->registry[$identifier])) {
            return $this->registry[$identifier];
        }

        throw new NotFoundException('A SystemInfo collector could not be found.', $identifier);
    }

    /**
     * Returns the identifiers of all registered SystemInfoCollectors.
     *
     * @return string[] Array of identifier strings.
     */
    public function getIdentifiers()
    {
        return array_keys($this->registry);
    }
}

class_alias(IdentifierBased::class, 'EzSystems\EzSupportToolsBundle\SystemInfo\Registry\IdentifierBased');
