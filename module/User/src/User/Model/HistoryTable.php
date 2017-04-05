<?php
namespace User\Model;
 
use Zend\Db\TableGateway\TableGateway;
 
class HistoryTable
{
    protected $tableGateway;
 
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    /**
    * Получение всех историй посещения определённого пользователя
    *@param $id_user
    *@return $rowset
    */
    public function getHistory($id_user)
    {
        $id_user  = (int) $id_user;       
        $rowset = $this->tableGateway->select(array('id_user' => $id_user));
        
        return $rowset;
    }
    /**
    * Сохранение истории
    *@param History $history
    */
    public function saveHistory(History $history)
    {
        $data = array(            
            'date' => $history->date,
            'ip' => $history->ip,            
            'id_user'  => $history->id_user,
        );        
        $this->tableGateway->insert($data);
         
    } 
}