<?php
namespace User\Model;
 
class History
{
    public $id;
    public $date;
    public $ip;
    public $id_user;

    /**
    * Инициализация полей из таблицы истории
    *@param $data
    */ 
    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;
        $this->date = (isset($data['date'])) ? $data['date'] : null;
        $this->ip  = (isset($data['ip'])) ? $data['ip'] : null;
        $this->id_user  = (isset($data['id_user'])) ? $data['id_user'] : null;

    }
}