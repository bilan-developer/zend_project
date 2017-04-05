<?php
namespace Money\Model;
 
use Zend\Db\TableGateway\TableGateway;
 
class CategoryTable
{
    protected $tableGateway;
 
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
     /**
    * Получение всех категорий расходов  
    */
    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    } 
   
}