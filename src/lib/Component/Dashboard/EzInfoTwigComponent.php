<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\SystemInfo\Component\Dashboard;

use Ibexa\Bundle\SystemInfo\SystemInfo\Value\IbexaSystemInfo;
use Ibexa\Contracts\AdminUi\Component\Renderable;
use Twig\Environment;

readonly class EzInfoTwigComponent implements Renderable
{
    /**
     * @param array<string, string> $urlList
     * @param array<string, mixed> $parameters
     */
    public function __construct(
        private Environment $twig,
        private string $template,
        private IbexaSystemInfo $ibexaSystemInfo,
        private array $urlList,
        private array $parameters = []
    ) {
    }

    /**
     * @param array<string, mixed> $parameters
     */
    public function render(array $parameters = []): string
    {
        $urls = $this->replaceUrlPlaceholders();

        return $this->twig->render(
            $this->template,
            $parameters + ['urls' => $urls, 'ibexa' => $this->ibexaSystemInfo] + $this->parameters
        );
    }

    /**
     * @return array<string, string>
     */
    private function replaceUrlPlaceholders(): array
    {
        $urls = $this->urlList;
        foreach ($this->urlList as $urlName => $url) {
            foreach (get_object_vars($this->ibexaSystemInfo) as $attribute => $value) {
                if (\is_string($value) && \strpos($url, '{ez.' . $attribute . '}') !== false) {
                    $urls[$urlName] = \str_replace('{ez.' . $attribute . '}', $value, $url);
                }
            }
        }

        return $urls;
    }
}
