<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Bundle\SystemInfo\SystemInfo;

use Ibexa\Core\Base\Exceptions\NotFoundException;

/**
 * A registry of OutputFormats.
 */
final readonly class OutputFormatRegistry
{
    /**
     * @param \Ibexa\Bundle\SystemInfo\SystemInfo\OutputFormat[] $registry Hash of OutputFormats, with identifier string as key.
     */
    public function __construct(private array $registry = [])
    {
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
     * @return string[]
     */
    public function getIdentifiers(): array
    {
        return array_keys($this->registry);
    }
}
