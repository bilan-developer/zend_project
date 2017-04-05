<?php
namespace Access\Model;
 
class Resource
{
    public $id;
    public $resource_name;   
 	/**
    * Инициализация полей из таблицы ресурсов
    *@param $data
    */ 
    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;
        $this->resource_name = (isset($data['resource_name'])) ? $data['resource_name'] : null;
    }
}