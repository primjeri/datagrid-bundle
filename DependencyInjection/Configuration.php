<?php
/*
 * This file is part of PrimjeriDataGridBundle
 *
 * (c) Nikolay Georgiev <azazen09@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Primjeri\DataGridBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;

use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Configuration class
 *
 * @author Nikolay Georgiev <azazen09@gmail.com>
 * @since 1.0
 */
class Configuration implements ConfigurationInterface
{

    /**
     * (non-PHPdoc)
     * @see \Symfony\Component\Config\Definition\ConfigurationInterface::getConfigTreeBuilder()
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('primjeri_data_grid');

        $rootNode
            ->children()
                ->scalarNode('translation_domain')->defaultValue('PrimjeriDataGridBundle')->cannotBeEmpty()->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
