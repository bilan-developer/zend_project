<?php
namespace Money\Model;
 
use Zend\Db\TableGateway\TableGateway;
 
class ProfitTable
{
    protected $tableGateway;
 
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    /**
    * Получение всех доходов  
    */
    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    } 
    /**
    * Получение доходов по его id
    *@param $id
    *@return $row
    */ 
    public function getProfit($id)
    {
        $id  = (int) $id;       
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }
    /**
    * Выборка доходов по категориям и пользователя
    *@param $id_category
    *@param $id_user
    *@return $rowset
    */
    public function getProfitIdCategory($id_category,$id_user)
    {
        $id_category  = (int) $id_category;  
        $id_user  = (int) $id_user;  
        $rowset = $this->tableGateway->select(array('id_category' => $id_category, 'id_user' => $id_user));        
        return $rowset;
    }
    /**
    * Получение всех доходов определённого пользователя
    *@param $id_user
    *@return $rowset
    */
    public function getProfitIdUser($id_user)
    {
        $id_user  = (int) $id_user;       
        $rowset = $this->tableGateway->select(array('id_user' => $id_user));
        return $rowset;
    }
    /**
    * Сохранение доходов
    *@param Profit $profit
    */
    public function saveProfit(Profit $profit)
    {   
        $data = array(            
            'id_user'           => $profit->id_user,
            'sum'               => $profit->sum,
            'date'              => $profit->date,
            'id_category'=> $profit->id_category,
        ); 
        $id = (int)$profit->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getProfit($id)) { 
               $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }
    /**
    * Удаление доходов по id
    *@param $id_costs
    */
     public function deleteProfit($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
   
}