<?php
/**
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace EzSystems\EzSupportToolsBundle\Tests\View;

use eZ\Publish\Core\Base\Exceptions\NotFoundException;
use EzSystems\EzSupportToolsBundle\View\SystemInfoViewBuilder;

class SystemInfoViewBuilderTest extends \PHPUnit_Framework_TestCase
{
    private $configuratorMock;

    private $collectorMock;

    public function testMatches()
    {
        $builder = new SystemInfoViewBuilder($this->getConfiguratorMock(), []);
        self::assertTrue($builder->matches('support_tools.view.controller:viewInfoAction'));
    }

    public function testNotMatches()
    {
        $builder = new SystemInfoViewBuilder($this->getConfiguratorMock(), []);
        self::assertFalse($builder->matches('service:someAction'));
    }

    public function testBuildView()
    {
        $builder = new SystemInfoViewBuilder(
            $this->getConfiguratorMock(),
            ['test' => $this->getCollectorMock()]
        );

        $systemInfo = $this->getMock('SystemInfo');

        $this->getCollectorMock()
            ->method('collect')
            ->will($this->returnValue($systemInfo));

        $view = $builder->buildView(['systemInfoIdentifier' => 'test', 'viewType' => 'test']);
        self::assertSame($view->getInfo(), $systemInfo);
        self::assertEquals($view->getViewType(), 'test');
    }

    /**
     * @expectedException \eZ\Publish\Core\Base\Exceptions\NotFoundException
     */
    public function testBuildViewCollectorNotFound()
    {
        $builder = new SystemInfoViewBuilder($this->getConfiguratorMock(), []);
        $builder->buildView(['systemInfoIdentifier' => 'test']);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\eZ\Publish\Core\MVC\Symfony\View\Configurator
     */
    protected function getConfiguratorMock()
    {
        if (!isset($this->configuratorMock)) {
            $this->configuratorMock = $this->getMock('eZ\Publish\Core\MVC\Symfony\View\Configurator');
        }

        return $this->configuratorMock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\EzSystems\EzSupportToolsBundle\SystemInfo\Collector\SystemInfoCollector
     */
    protected function getCollectorMock()
    {
        if (!isset($this->collectorMock)) {
            $this->collectorMock = $this->getMock('EzSystems\EzSupportToolsBundle\SystemInfo\Collector\SystemInfoCollector');
        }

        return $this->collectorMock;
    }
}
