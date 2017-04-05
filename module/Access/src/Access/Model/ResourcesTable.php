<?php
namespace Access\Model;
 
use Zend\Db\TableGateway\TableGateway;
 
class ResourcesTable
{
    protected $tableGateway;
 
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    /**
    * Получение всех ресурсов  
    */
    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
    /**
    * Получение ресурса по его id
    *@param $id
    *@return  $row
    */
    public function getResource($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }/**
    * Получение имени ресурсов
    *@param $arr
    *@return  $name_resource
    */
    public function getNameResource($arr){
        $name_resource = [];              
        foreach ($arr as $key => $value){ 
                $resource = $this->tableGateway->select(array('id' => $value->id_resource));
                $row = $resource->current();
                
                if (!$row) {
                    throw new \Exception("Could not find row $value->id_resource");
                }else{
                    $name_resource[$value->id_resource] = $row->resource_name;
                } 
            }  
            return $name_resource;
    }
}