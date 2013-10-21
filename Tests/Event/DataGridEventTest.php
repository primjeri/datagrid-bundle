<?php
namespace Primjeri\DataGridBundle\Tests\Event;

use Primjeri\DataGridBundle\Event\QueryBuilderEvent;

use Primjeri\DataGridBundle\Event\RowPositionChangeEvent;

use Primjeri\DataGridBundle\Event\RowEvent;

use Primjeri\DataGridBundle\Event\QueryEvent;

use Primjeri\DataGridBundle\Event\DataEvent;

use Primjeri\DataGridBundle\Event\MassActionEvent;

use Primjeri\ComponentBundle\Test\Tool\BaseTestCase;

class DataGridEventTest extends BaseTestCase
{
    public function testDataEvent()
    {   
        $event = new DataEvent('test', array(array('key' => 'value')));

        $this->assertSame($event->getDataGridName(), 'test');
        $this->assertSame($event->getData(), array(array('key' => 'value')));
        $event->setData(array(array('key2' => 'value2')));
        $this->assertSame(array(array('key2' => 'value2')), $event->getData());
    }
    
    public function testMassActionEvent()
    {   
        $event = new MassActionEvent('test', 'someMassAction', array(1,2,3), true, new \stdClass());
        $event->setExtraData(array('key' => 'value'));
        
        $this->assertSame($event->getDataGridName(), 'test');
        $this->assertSame(array(1,2,3), $event->getIds());
        $this->assertTrue($event->getSelectAll());
        $this->assertSame('someMassAction', $event->getMassActionName());
        $this->assertInstanceOf('stdClass', $event->getQuery());
        $this->assertSame(array('key' => 'value'), $event->getExtraData());
    }
    
    public function testQueryEvent()
    {
        $event = new QueryEvent('test', new \stdClass());
        
        $this->assertSame('test', $event->getDataGridName());
        $this->assertInstanceOf('stdClass', $event->getQuery());
    }
    
    public function testRowEvent()
    {
        $event = new RowEvent('test', 1);
        
        $this->assertSame('test', $event->getDataGridName());
        $this->assertSame(1, $event->getId());
        $this->assertFalse($event->getSuccess());
        $this->assertEmpty($event->getData());
        $this->assertEmpty($event->getErrors());
        
        $event->setSuccess(true);
        $event->setData(array('data'));
        $event->setErrors(array('errors'));
        
        $this->assertTrue($event->getSuccess());
        $this->assertSame(array('data'), $event->getData());
        $this->assertSame(array('errors'), $event->getErrors());
    }
    
    public function testRowPositionChangeEvent()
    {
        $event = new RowPositionChangeEvent('test', 1, 10);
        
        $this->assertSame('test', $event->getDataGridName());
        $this->assertSame(1, $event->getRowId());
        $this->assertSame(9, $event->getRowPosition());
        $this->assertEmpty($event->getExtraData());
        
        $event->setExtraData(array('extra'));
        $this->assertSame(array('extra'), $event->getExtraData());
    }
    
    public function testQueryBuilderEvent()
    {
        $event = new QueryBuilderEvent('test', new \stdClass());
        
        $this->assertSame('test', $event->getDataGridName());
        $this->assertInstanceOf('stdClass', $event->getQueryBuilder());
    }

}