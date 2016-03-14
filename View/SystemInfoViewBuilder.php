<?php
/**
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace EzSystems\EzSupportToolsBundle\View;

use Doctrine\Common\Inflector\Inflector;
use eZ\Publish\Core\MVC\Symfony\View\Builder\ViewBuilder;
use EzSystems\EzSupportToolsBundle\SystemInfo\Collector\SystemInfoCollector;

class SystemInfoViewBuilder implements ViewBuilder
{
    /**
     * @var \EzSystems\EzSupportToolsBundle\SystemInfo\Collector\SystemInfoCollector
     */
    private $infoCollector;

    public function __construct(SystemInfoCollector $infoCollector)
    {
        $this->infoCollector = $infoCollector;
    }

    public function matches($argument)
    {
        return $argument === 'support_tools.view.controller:viewInfoAction';
    }

    public function buildView(array $parameters)
    {
        $view = new SystemInfoView();
        $view->setInfo($this->infoCollector->build());
        $view->setTemplateIdentifier(
            $this->toTemplateIdentifier($view->getInfo())
        );

        return $view;
    }

    private function toTemplateIdentifier($object)
    {
        $className = get_class($object);
        $className = substr($className, strrpos($className, '\\') + 1);

        return Inflector::tableize($className) . ".html.twig";
    }
}
