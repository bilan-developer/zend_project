<?php
namespace Money\Model;
 
use Zend\Db\TableGateway\TableGateway;
 
class CategoryProfitTable
{
    protected $tableGateway;
 
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    /**
    * Получение всех категорий доходов  
    */
    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    } 
    
   
}