<?php
namespace Primjeri\DataGridBundle\Tests\DependancyInjection;

use Primjeri\ComponentBundle\Test\Tool\BaseTestCase;

use Primjeri\DataGridBundle\DependencyInjection\PrimjeriDataGridExtension;

use Symfony\Component\DependencyInjection\ContainerBuilder;

class PrimjeriDataGridExtensionTest extends BaseTestCase
{
    public function testDefault ()
    {
        $container = new ContainerBuilder();
        $loader = new PrimjeriDataGridExtension();
        $loader->load(array(array()), $container);
        
        $this->assertTrue($container->hasDefinition('primjeri_data_grid.provider'));
        
        $this->assertTrue($container->hasDefinition('primjeri_data_grid.factory.datagrid'));
        
        $this->assertTrue($container->hasDefinition('primjeri_data_grid.doctrine.orm.handler.datagrid'));
        
        $this->assertTrue($container->hasAlias('primjeri_data_grid.handler.datagrid'));
        
        $this->assertTrue($container->hasParameter('primjeri_data_grid.translation_domain'));
                
        $this->assertTrue($container->hasDefinition('primjeri_data_grid.twig.extension.datagrid'));
        
        $this->assertTrue($container->getDefinition('primjeri_data_grid.twig.extension.datagrid')
             ->hasTag('twig.extension')
        );
    
    }
}