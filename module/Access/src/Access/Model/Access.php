<?php
namespace Access\Model;
 
class Access
{
    public $id;
    public $id_role;
    public $id_resource;
    public $access;
   
    /**
    * Инициализация полей из таблицы доступов
    *@param $data
    */ 
    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;
        $this->id_role = (isset($data['id_role'])) ? $data['id_role'] : null;
        $this->id_resource = (isset($data['id_resource'])) ? $data['id_resource'] : null;
        $this->access = (isset($data['access'])) ? $data['access'] : null;

    }
}