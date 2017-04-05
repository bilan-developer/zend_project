<?php
namespace Access\Model;
 
use Zend\Db\TableGateway\TableGateway;
 
class RolesTable
{
    protected $tableGateway;
 
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    /**
    * Получение всех ролей  
    */
    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
    /**
    * Получение роли по его id
    *@param $id
    *@return  $row
    */
    public function getRole($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }
}