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

use Symfony\Component\DependencyInjection\ContainerBuilder;

use Symfony\Component\Config\FileLocator;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;

use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class PrimjeriDataGridExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
        
        $container->setParameter('primjeri_data_grid.translation_domain', $config['translation_domain']);
        
        $container->setAlias('primjeri_data_grid.handler.datagrid', 'primjeri_data_grid.doctrine.orm.handler.datagrid');

    }
}
