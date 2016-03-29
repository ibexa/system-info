<?php
/**
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace EzSystems\EzSupportToolsBundle\View;

use Doctrine\Common\Inflector\Inflector;
use eZ\Publish\Core\Base\Exceptions\NotFoundException;
use eZ\Publish\Core\MVC\Symfony\View\Builder\ViewBuilder;
use eZ\Publish\Core\MVC\Symfony\View\Configurator;
use EzSystems\EzSupportToolsBundle\SystemInfo\Collector\SystemInfoCollector;

class SystemInfoViewBuilder implements ViewBuilder
{
    /**
     * @var \EzSystems\EzSupportToolsBundle\SystemInfo\Collector\SystemInfoCollector[]
     */
    private $infoCollectors;
    /**
     * @var \eZ\Publish\Core\MVC\Symfony\View\Configurator
     */
    private $viewConfigurator;

    public function __construct(Configurator $viewConfigurator, array $infoCollectors)
    {
        $this->infoCollectors = $infoCollectors;
        $this->viewConfigurator = $viewConfigurator;
    }

    public function matches($argument)
    {
        return $argument === 'support_tools.view.controller:viewInfoAction';
    }

    public function buildView(array $parameters)
    {
        $collector = $this->getCollector($parameters['systemInfoIdentifier']);
        $view = new SystemInfoView();
        $view->setInfo($collector->collect());

        $this->viewConfigurator->configure($view);

        return $view;
    }

    /**
     * @param string $identifier A SystemInfo collector identifier (php, hardware...)
     *
     * @return \EzSystems\EzSupportToolsBundle\SystemInfo\Collector\SystemInfoCollector
     * @throws \eZ\Publish\Core\Base\Exceptions\NotFoundException If no SystemInfoCollector exists with this identifier
     */
    private function getCollector($identifier)
    {
        if (!isset($this->infoCollectors[$identifier])) {
            throw new NotFoundException("A SystemInfo collector could not be found.", $identifier);
        }

        return $this->infoCollectors[$identifier];
    }
}
