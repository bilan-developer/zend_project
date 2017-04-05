<?php
namespace Money\Model;
 
use Zend\Db\TableGateway\TableGateway;
 
class CostsTable
{
    protected $tableGateway;
 
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    /**
    * Получение всех расходов  
    */
    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }   
    /**
    * Получение расходов по его id
    *@param $id
    *@return $row
    */  
    public function getCosts($id)
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
    * Получение всех расходов определённого пользователя
    *@param $id_user
    *@return $rowset
    */
    public function getCostsIdUser($id_user)
    {
        $id_user  = (int) $id_user;       
        $rowset = $this->tableGateway->select(array('id_user' => $id_user));
        return $rowset;
    }
    /**
    * Выборка расходов по категориям и пользователя
    *@param $id_category
    *@param $userId
    *@return $rowset
    */
    public function getCostsIdCategory($id_category,$userId)
    {
        $id_category  = (int) $id_category;  
        $userId  = (int) $userId;  
        $rowset = $this->tableGateway->select(array('id_category' => $id_category, 'id_user' => $userId));        
        return $rowset;
    }
    /**
    * Сохранение расходов
    *@param Costs $costs
    */
    public function saveCosts(Costs $costs)
    {      
        $data = array(            
            'id_user'       => $costs->id_user,
            'date'          => $costs->date,            
            'id_category'   => $costs->id_category,
            'sum'           => $costs->sum,
        ); 
        $id = (int)$costs->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getCosts($id)) { 
               $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }
    /**
    * Удаление расходов по id
    *@param $id_costs
    */
    public function deleteCosts($id_costs)
    {
        $this->tableGateway->delete(array('id' => $id_costs));
    }
}