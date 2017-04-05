<?php
namespace Money\Model;
 
class Category
{
    public $id;
    public $name_category;

 	/**
    * Инициализация полей из таблицы категори расходов
    *@param $data
    */ 
    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;
        $this->name_category = (isset($data['name_category'])) ? $data['name_category'] : null;
    }
}