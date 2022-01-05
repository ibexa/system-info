<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace Ibexa\Bundle\SystemInfo\View;

use Ibexa\Core\MVC\Symfony\View\BaseView;
use Ibexa\Core\MVC\Symfony\View\View;

class SystemInfoView extends BaseView implements View
{
    /**
     * @var \Ibexa\Bundle\SystemInfo\SystemInfo\Value\SystemInfo
     */
    private $info;

    /**
     * @param \Ibexa\Bundle\SystemInfo\SystemInfo\Value\SystemInfo $info
     *
     * @return SystemInfoView
     */
    public function setInfo($info)
    {
        $this->info = $info;

        return $this;
    }

    /**
     * @return \Ibexa\Bundle\SystemInfo\SystemInfo\Value\SystemInfo
     */
    public function getInfo()
    {
        return $this->info;
    }

    protected function getInternalParameters()
    {
        return ['info' => $this->info];
    }
}

class_alias(SystemInfoView::class, 'EzSystems\EzSupportToolsBundle\View\SystemInfoView');
