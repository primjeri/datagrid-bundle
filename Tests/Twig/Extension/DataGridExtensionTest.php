<?php
namespace Primjeri\DataGridBundle\Tests\Twig\Extension;

use Primjeri\ComponentBundle\Test\Tool\BaseTestCase;

use Primjeri\DataGridBundle\Twig\Extension\DataGridExtension;

use Symfony\Component\DependencyInjection\Container;

class DataGridExtensionTest extends  BaseTestCase
{
    
    public function testDataGridExtension()
    {
        
        $dataGridMock = 
            $this->getMock('Primjeri\DataGridBundle\DataGrid\DataGridInterface');
        
        $templatingMock = 
            $this->getMockBuilder('Symfony\Bundle\TwigBundle\TwigEngine')
                 ->disableOriginalConstructor()->getMock();
        
        $templatingMock
            ->expects($this->once())
            ->method('render')
            ->with('PrimjeriDataGridBundle:DataGrid:index.html.twig', array(
                'dataGrid' => $dataGridMock, 'translationDomain' => 'messages'
            ))
            ->will($this->returnValue('<table>test</table>'))
        ;
        
        $container = new Container();
        $container->setParameter('primjeri_data_grid.translation_domain', 'messages');
        $container->set('templating', $templatingMock);
        
        $this->assertEquals(
            '<table>test</table>', 
            $this->getTemplate('{{ primjeri_datagrid(dataGrid) }}', $container)
                ->render(array('dataGrid' => $dataGridMock))
        );
    }
    
    public function testDataGridExtensionWithString()
    {
        
        $dataGridMock = 
            $this->getMock('Primjeri\DataGridBundle\DataGrid\DataGridInterface');
        
        $providerMock = $this->getMock('Primjeri\DataGridBundle\DataGrid\Provider\DataGridProviderInterface');
        $providerMock
            ->expects($this->once())
            ->method('get')
            ->with('myDataGrid')
            ->will($this->returnValue($dataGridMock))
        ;
        
        $templatingMock = 
            $this->getMockBuilder('Symfony\Bundle\TwigBundle\TwigEngine')
                 ->disableOriginalConstructor()->getMock();
        
        $templatingMock
            ->expects($this->once())
            ->method('render')
            ->with('PrimjeriDataGridBundle:DataGrid:index.html.twig', array(
                'dataGrid' => $dataGridMock, 'translationDomain' => 'messages'
            ))
            ->will($this->returnValue('<table>test</table>'))
        ;
        
        $container = new Container();
        $container->setParameter('primjeri_data_grid.translation_domain', 'messages');
        $container->set('templating', $templatingMock);
        $container->set('primjeri_data_grid.provider', $providerMock);
        
        $this->assertEquals(
            '<table>test</table>', 
            $this->getTemplate("{{ primjeri_datagrid('myDataGrid') }}", $container)
                ->render(array())
        );
    }
    
    private function getTemplate($template, $container)
    {
        $loader = new \Twig_Loader_Array(array('index' => $template));
        $twig = new \Twig_Environment($loader, array('debug' => true, 'cache' => false));
        $twig->addExtension(new DataGridExtension($container));
    
        return $twig->loadTemplate('index');
    }
}