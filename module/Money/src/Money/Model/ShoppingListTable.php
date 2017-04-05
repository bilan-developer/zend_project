<?php
namespace Money\Model;
 
use Zend\Db\TableGateway\TableGateway;
 
class ShoppingListTable
{
    protected $tableGateway;
 
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    /**
    * Получение всех списков покупок 
    */
    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }  
    /**
    * Получение списка покупок по его id
    *@param $id
    *@return $row
    */   
    public function getShoppingList($id)
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
    * Получение всех списков покупок определённого пользователя
    *@param $id_user
    *@return $rowset
    */
    public function getShoppingListIdUser($id_user)
    {
        $id_user  = (int) $id_user;       
        $rowset = $this->tableGateway->select(array('id_user' => $id_user));
        
        return $rowset;
    }
    
    /**
    * Сохранение списка покупок
    *@param ShoppingList $shoppingList
    */
    public function saveShoppingList(ShoppingList $shoppingList)
    {   
        $data = array(            
            'name_list'     => $shoppingList->name_list,
            'sum'           => $shoppingList->sum,
            'id_user'       => $shoppingList->id_user,
        ); 
        $id = (int)$shoppingList->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getShoppingList($id)) { 
                $data['status'] = $shoppingList->status;
                $data['date'] = $shoppingList->date;
               $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }
    /**
    * Удаление списка покупок по id
    *@param $id
    */
     public function deleteShoppingList($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
}