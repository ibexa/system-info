<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace Ibexa\Bundle\SystemInfo\View;

use Ibexa\Bundle\SystemInfo\SystemInfo\Value\SystemInfo;
use Ibexa\Core\MVC\Symfony\View\BaseView;
use Ibexa\Core\MVC\Symfony\View\View;

class SystemInfoView extends BaseView implements View
{
    private SystemInfo $info;

    public function setInfo(SystemInfo $info): self
    {
        $this->info = $info;

        return $this;
    }

    public function getInfo(): SystemInfo
    {
        return $this->info;
    }

    /**
     * @return array{info: \Ibexa\Bundle\SystemInfo\SystemInfo\Value\SystemInfo}
     */
    protected function getInternalParameters(): array
    {
        return ['info' => $this->info];
    }
}

class_alias(SystemInfoView::class, 'EzSystems\EzSupportToolsBundle\View\SystemInfoView');
