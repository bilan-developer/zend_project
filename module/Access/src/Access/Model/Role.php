<?php
namespace Access\Model;
 
class Role
{
    public $id;
    public $role_name;
   
 	/**
    * Инициализация полей из таблицы ролей
    *@param $data
    */ 
    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;
        $this->role_name = (isset($data['role_name'])) ? $data['role_name'] : null;
    }
}