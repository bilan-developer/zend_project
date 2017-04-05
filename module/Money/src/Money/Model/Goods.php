<?php
namespace Money\Model;
 
class Goods
{
    public $id;
    public $name_goods;
    public $sum;
    public $id_list;
   

    /**
    * Инициализация полей из таблицы товаров
    *@param $data
    */ 
    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;
        $this->name_goods = (isset($data['name_goods'])) ? $data['name_goods'] : null;
        $this->id_list = (isset($data['id_list'])) ? $data['id_list'] : null;       
        $this->sum = (isset($data['sum'])) ? $data['sum'] : null;
    }
}