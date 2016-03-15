<?php
/**
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace EzSystems\EzSupportToolsBundle\View;

use Doctrine\Common\Inflector\Inflector;
use eZ\Publish\Core\Base\Exceptions\NotFoundException;
use eZ\Publish\Core\MVC\Symfony\View\Builder\ViewBuilder;
use EzSystems\EzSupportToolsBundle\SystemInfo\Collector\SystemInfoCollector;

class SystemInfoViewBuilder implements ViewBuilder
{
    /**
     * @var \EzSystems\EzSupportToolsBundle\SystemInfo\Collector\SystemInfoCollector[]
     */
    private $infoCollectors;

    public function __construct(array $infoCollectors)
    {
        $this->infoCollectors = $infoCollectors;
    }

    public function matches($argument)
    {
        return $argument === 'support_tools.view.controller:viewInfoAction';
    }

    public function buildView(array $parameters)
    {
        $collector = $this->getCollector($parameters['systemInfoIdentifier']);
        $view = new SystemInfoView();
        $view->setInfo($collector->build());
        $view->setTemplateIdentifier(
            $this->toTemplateIdentifier($view->getInfo())
        );

        return $view;
    }

    private function toTemplateIdentifier($object)
    {
        return 'ez-support-tools/info/' . $this->toIdentifier($object) . ".html.twig";
    }

    private function toIdentifier($object)
    {
        $className = get_class($object);
        $className = substr($className, strrpos($className, '\\') + 1);
        $className = str_replace('SystemInfo', '', $className);

        return Inflector::tableize($className);
    }

    /**
     * @return \EzSystems\EzSupportToolsBundle\SystemInfo\Collector\SystemInfoCollector
     */
    private function getCollector($identifier)
    {
        if (!isset($this->infoCollectors[$identifier])) {
            throw new NotFoundException("A SystemInfo collector could not be found.", $identifier);
        }

        return $this->infoCollectors[$identifier];
    }
}
