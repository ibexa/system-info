<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Bundle\SystemInfo\View\Matcher\SystemInfo;

use Ibexa\Bundle\SystemInfo\View\SystemInfoView;
use Ibexa\Core\MVC\Symfony\Matcher\ViewMatcherInterface;
use Ibexa\Core\MVC\Symfony\View\View;
use RuntimeException;

final class Identifier implements ViewMatcherInterface
{
    /**
     * Matched SystemInfo identifier. Example: 'php', 'hardware'...
     */
    private string $identifier;

    public function setMatchingConfig(mixed $matchingConfig): void
    {
        $this->identifier = $matchingConfig;
    }

    /**
     * Matches the $view against a set of matchers.
     */
    public function match(View $view): bool
    {
        if (!$view instanceof SystemInfoView) {
            return false;
        }

        return $this->toIdentifier($view->getInfo()) === $this->identifier;
    }

    private function toIdentifier(object $object): string
    {
        $className = get_class($object);
        $className = substr($className, strrpos($className, '\\') + 1);
        $className = str_replace('SystemInfo', '', $className);

        return $this->normalizeName($className);
    }

    private function normalizeName(string $name): string
    {
        $normalized = preg_replace('~(?<=\\w)([A-Z])~u', '_$1', $name);

        if ($normalized === null) {
            throw new RuntimeException(sprintf(
                'preg_replace returned null for value "%s"',
                $name
            ));
        }

        return mb_strtolower($normalized);
    }
}
