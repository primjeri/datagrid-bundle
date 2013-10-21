<?php
/*
 * This file is part of PrimjeriDataGridBundle
 *
 * (c) Nikolay Georgiev <azazen09@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Primjeri\DataGridBundle\DataGrid;

/**
 * Factory to create a datagrid
 *
 * @author Nikolay Georgiev <azazen09@gmail.com>
 * @since 1.0
 */
class DataGridFactory implements DataGridFactoryInterface
{   
    /**
     * (non-PHPdoc)
     * @see \Primjeri\DataGridBundle\DataGrid\DataGridFactoryInterface::createDataGrid()
     */
    public function createDataGrid ($name)
    {
        return new DataGrid($name);
    }
}