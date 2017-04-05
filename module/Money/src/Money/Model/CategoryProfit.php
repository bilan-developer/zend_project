<?php
namespace Money\Model;
 
class CategoryProfit
{
    public $id;
    public $name_profit;

 	/**
    * Инициализация полей из таблицы категори доходов
    *@param $data
    */ 
    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;
        $this->name_profit = (isset($data['name_profit'])) ? $data['name_profit'] : null;
    }
}