<?php
/*
 * This file is part of PrimjeriDataGridBundle
 *
 * (c) Nikolay Georgiev <symfonist@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Primjeri\DataGridBundle\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * MassAction Event Class 
 *
 * @author Nikolay Georgiev <symfonist@gmail.com>
 * @since 1.0
 */
class MassActionEvent extends Event
{

    /**
     * @var string
     */
    protected $dataGridName;
    
    /**
     * @var string
     */
    protected $massActionName;

    /**
     * @var Array
     */
    protected $ids = array();
    
    /**
     * @var boolean
     */
    protected $selectAll = false;
    
    /**
     * @var Object
     */
    protected $query;
    
    /**
     * @var integer
     */
    protected $extraData = array();

    /**
     * Construct
     * 
     * @param string $dataGridName
     * @param string $massActionName
     * @param array $ids
     */
    public function __construct ($dataGridName, $massActionName, array $ids, $selectAll, $query)
    {
        $this->dataGridName = (string) $dataGridName;
        $this->massActionName = (string) $massActionName;
        $this->ids = $ids;
        $this->selectAll = (bool) $selectAll;
        $this->query = $query;
    }

    /**
     * Gets DataGrid name
     * 
     * @return string
     */
    public function getDataGridName () 
    {
        return $this->dataGridName;
    }

    /**
     * Gets mass action name
     * 
     * @return string
     */
    public function getMassActionName()
    {
        return $this->massActionName;
    }


    /**
     * Gets the ids to apply mass action
     *
     * @return Array
     */
    public function getIds ()
    {
        return $this->ids;
    }  
    
    /**
     * Gets selectAll flag
     * 
     * @return boolean
     */
    public function getSelectAll()
    {
        return $this->selectAll;
    }
    
    /**
     * 
     * Gets Query Object
     * 
     * @return object
     */
    public function getQuery()
    {
        return $this->query;
    }
    
    /**
     * Sets extra data used for response
     * 
     * @param array $extraData
     * @return Primjeri\DataGridBundle\Event\MassActionEvent
     */
    public function setExtraData(array $extraData)
    {
        $this->extraData = $extraData;
        
        return $this;
    }
    
    /**
     * Retrieve extra data (used for response)
     * 
     * @return mixed | array
     */
    public function getExtraData()
    {
        return $this->extraData;
    }
}