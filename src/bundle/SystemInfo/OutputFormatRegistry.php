<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
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
    private array $registry = [];

    /**
     * @param \Ibexa\Bundle\SystemInfo\SystemInfo\OutputFormat[] $items Hash of OutputFormats, with identifier string as key.
     */
    public function __construct(array $items = [])
    {
        $this->registry = $items;
    }

    /**
     * @throws \Ibexa\Core\Base\Exceptions\NotFoundException If no OutputFormat exists with this identifier
     */
    public function getItem(string $identifier): OutputFormat
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
    public function getIdentifiers(): array
    {
        return array_keys($this->registry);
    }
}

class_alias(OutputFormatRegistry::class, 'EzSystems\EzSupportToolsBundle\SystemInfo\OutputFormatRegistry');
