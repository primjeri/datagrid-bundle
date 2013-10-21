<?php
namespace Primjeri\DataGridBundle\Tests\DataGrid\DataGridFactoryTest;

use Primjeri\ComponentBundle\Test\Tool\BaseTestCase;

class DataGridFactoryTest extends BaseTestCase
{

    public function testCreateDataGrid()
    {
        $factory = new \Primjeri\DataGridBundle\DataGrid\DataGridFactory();
        $dataGrid = $factory->createDataGrid('test');
        
        $this->assertInstanceOf('\Primjeri\DataGridBundle\DataGrid\DataGridInterface', $dataGrid);
        $this->assertSame('test', $dataGrid->getName());

    }   
}
