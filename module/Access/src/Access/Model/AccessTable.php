<?php
namespace Access\Model;
 
use Zend\Db\TableGateway\TableGateway;
 
class AccessTable
{
    protected $tableGateway;
 
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    /**
    * Получение всех доступов  
    */
    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
    /**
    * Получение доступа по его id
    *@param $id_role
    *@return  $resultSet
    */
    public function getAccess($id_role)
    {        
        $id_role  = (int) $id_role;
        $resultSet = $this->tableGateway->select(array('id_role' => $id_role));        
        return $resultSet;
    }  
    /**
    * Закрытие доступа
    *@param $id_role
    *@param $id_resource
    *@return  $row
    */  
    public function closeAccess($id_role, $id_resource)
    {        
        $id_role  = (int) $id_role;
        $id_resource  = (int) $id_resource;
        $resultSet = $this->tableGateway->select(array('id_role' => $id_role, 'id_resource' => $id_resource));
        $row = $resultSet->current();            
            if (!$row) {
                throw new \Exception("Error");
            }   
        return $row;
    }  
    /**
    * Cохранение доступа
    *@param Access=>$access
    *@param boolean=>true
    */  
    public function saveAccess(Access $access)
    {   
        $data = array(
            'id' => $access->id,    
            'id_role' => $access->id_role,
            'id_resource' => $access->id_resource,
            'access' => $access->access, 
        ); 
        if ($this->getAccess($access->id)) {

            $this->tableGateway->update($data, array('id' => $access->id));
        } else {
            throw new \Exception('Form id does not exist');
        }
        return true;
    }  
}