<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace Ibexa\Bundle\SystemInfo\Controller;

use Ibexa\Bundle\SystemInfo\SystemInfo\SystemInfoCollectorRegistry;
use Ibexa\Bundle\SystemInfo\View\SystemInfoView;
use Ibexa\Contracts\AdminUi\Controller\Controller as AdminUiController;
use Ibexa\Core\MVC\Symfony\Security\Authorization\Attribute;
use Symfony\Component\HttpFoundation\Response;

class SystemInfoController extends AdminUiController
{
    public function __construct(
        private readonly SystemInfoCollectorRegistry $collectorRegistry
    ) {
    }

    public function performAccessCheck(): void
    {
        parent::performAccessCheck();
        $this->denyAccessUnlessGranted(new Attribute('setup', 'system_info'));
    }

    /**
     * Renders the system information page.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function infoAction(): Response
    {
        return $this->render('@ibexadesign/system_info/info.html.twig', [
            'collector_identifiers' => $this->collectorRegistry->getIdentifiers(),
        ]);
    }

    public function viewInfoAction(SystemInfoView $view): SystemInfoView
    {
        return $view;
    }

    public function phpinfoAction(): Response
    {
        ob_start();
        phpinfo();

        return new Response(ob_get_clean() ?: '');
    }
}
