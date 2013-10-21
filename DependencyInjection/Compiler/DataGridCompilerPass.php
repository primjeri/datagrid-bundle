<?php
/*
 * This file is part of PrimjeriDataGridBundle
 *
 * (c) Nikolay Georgiev <azazen09@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Primjeri\DataGridBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

use Symfony\Component\DependencyInjection\Reference;

/**
 * Default implementation of CompilerPassInterface
 *
 * @author Nikolay Georgiev <azazen09@gmail.com>
 * @since 1.0
 */
class DataGridCompilerPass implements CompilerPassInterface
{
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\DependencyInjection\Compiler.CompilerPassInterface::process()
     */
    public function process (ContainerBuilder $container)
    {
        if (!$container->hasDefinition('primjeri_data_grid.provider')) {
            return;
        }
                
        $definition = $container->getDefinition('primjeri_data_grid.provider');
        
        $dataGrids = array();
        
        foreach ($container->findTaggedServiceIds('primjeri_data_grid.datagrid') as $id => $tags) {
            foreach ($tags as $attributes) {
                if (empty($attributes['alias'])) {
                    throw new \InvalidArgumentException(
                        sprintf('The alias is not defined in the "primjeri_data_grid.datagrid" tag for the service "%s"', $id)
                    );
                }
                
                $dataGrids[$attributes['alias']] = $id;
            }
        }
        
        $definition->replaceArgument(1, $dataGrids);
    }
}
