<?php
namespace Money\Model;
 
use Zend\Db\TableGateway\TableGateway;
 
class GoodsTable
{
    protected $tableGateway;
 
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    /**
    * Получение всех товаров  
    */
    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }   
    /**
    * Получение товара по его id
    *@param $id
    *@return $row
    */    
    public function getGoods($id)
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
    * Получение всех товаров определённого списка
    *@param $id_list
    *@return $rowset
    */
    public function getGoodsIdList($id_list)
    {
        $id_list  = (int) $id_list;       
        $rowset = $this->tableGateway->select(array('id_list' => $id_list));
        return $rowset;
    }
    /**
    * Сохранение товара
    *@param Goods $goods
    */
    public function saveGoods(Goods $goods)
    {   
        $data = array(            
            'name_goods'    => $goods->name_goods,
            'sum'           => $goods->sum,
            'id_list'       => $goods->id_list,
        ); 
        $id = (int)$goods->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getGoods($id)) { 
               $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }
    /**
    * Удаление расходов по id
    *@param $id
    */
     public function deleteGoods($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
    /**
    * Удаление расходов по id списка
    *@param $id_list
    */
    public function deleteGoodsList($id_list)
    {
        $this->tableGateway->delete(array('id_list' => $id_list));
    }
}