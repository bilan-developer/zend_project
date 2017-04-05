<?php
namespace Money\Model;
 
class Costs
{
    public $id;
    public $id_user;
    public $date;
    public $id_category;
    public $sum;

    /**
    * Инициализация полей из таблицы расходов
    *@param $data
    */ 
    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;
        $this->id_user = (isset($data['id_user'])) ? $data['id_user'] : null;
        $this->date = (isset($data['date'])) ? $data['date'] : null;
        $this->id_category = (isset($data['id_category'])) ? $data['id_category'] : null;
        $this->sum = (isset($data['sum'])) ? $data['sum'] : null;
    }
}