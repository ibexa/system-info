<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace Ibexa\Bundle\SystemInfo\SystemInfo;

use Ibexa\Core\Base\Exceptions\NotFoundException;

/**
 * A registry of OutputFormats.
 */
class OutputFormatRegistry
{
    /** @var \Ibexa\Bundle\SystemInfo\SystemInfo\OutputFormat[] */
    private $registry = [];

    /**
     * @param \Ibexa\Bundle\SystemInfo\SystemInfo\OutputFormat[] $items Hash of OutputFormats, with identifier string as key.
     */
    public function __construct(array $items = [])
    {
        $this->registry = $items;
    }

    /**
     * Returns the OutputFormat matching the argument.
     *
     * @param string $identifier An identifier string.
     *
     * @throws \Ibexa\Core\Base\Exceptions\NotFoundException If no OutputFormat exists with this identifier
     *
     * @return \Ibexa\Bundle\SystemInfo\SystemInfo\Collector\OutputFormat The OutputFormat given by the identifier.
     */
    public function getItem($identifier)
    {
        if (isset($this->registry[$identifier])) {
            return $this->registry[$identifier];
        }

        throw new NotFoundException('A SystemInfo output format could not be found.', $identifier);
    }

    /**
     * Returns the identifiers of all registered OutputFormats.
     *
     * @return string[] Array of identifier strings.
     */
    public function getIdentifiers()
    {
        return array_keys($this->registry);
    }
}

class_alias(OutputFormatRegistry::class, 'EzSystems\EzSupportToolsBundle\SystemInfo\OutputFormatRegistry');
