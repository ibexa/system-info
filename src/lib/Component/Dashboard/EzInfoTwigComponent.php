<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\SystemInfo\Component\Dashboard;

use Ibexa\Bundle\SystemInfo\SystemInfo\Value\IbexaSystemInfo;
use Ibexa\Contracts\TwigComponents\ComponentInterface;
use Twig\Environment;

/**
 * @deprecated Since ibexa/system-info 4.6: The "EzInfoTwigComponent" class is deprecated, will be removed in 5.0.
 */
class EzInfoTwigComponent implements ComponentInterface
{
    protected string $template;

    protected Environment $twig;

    /** @var array<string, mixed> */
    protected array $parameters;

    private IbexaSystemInfo $ibexaSystemInfo;

    /** @var array<string, string> */
    private array $urlList;

    /**
     * @param array<string, string> $urlList
     * @param array<string, mixed>  $parameters
     */
    public function __construct(
        Environment $twig,
        string $template,
        IbexaSystemInfo $ibexaSystemInfo,
        array $urlList,
        array $parameters = []
    ) {
        $this->twig = $twig;
        $this->template = $template;
        $this->parameters = $parameters;
        $this->ibexaSystemInfo = $ibexaSystemInfo;
        $this->urlList = $urlList;
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

class_alias(EzInfoTwigComponent::class, 'EzSystems\EzSupportTools\Component\Dashboard\EzInfoTwigComponent');
