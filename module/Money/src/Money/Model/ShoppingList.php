<?php
namespace Money\Model;
 
class ShoppingList
{
    public $id;
    public $name_list;
    public $sum;
    public $id_user;
    public $status;
    public $date;

   

    /**
    * Инициализация полей из таблицы списки покупок
    *@param $data
    */ 
    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;
        $this->id_user = (isset($data['id_user'])) ? $data['id_user'] : null;
        $this->name_list = (isset($data['name_list'])) ? $data['name_list'] : null;       
        $this->sum = (isset($data['sum'])) ? $data['sum'] : null;
        $this->status = (isset($data['status'])) ? $data['status'] : null;
        $this->date = (isset($data['date'])) ? $data['date'] : null;
    }
}