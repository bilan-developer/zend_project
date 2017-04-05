<?php
namespace User\Model;
 
use Zend\Db\TableGateway\TableGateway;
 
class UsersTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    /**
    * Получение всех пользователей
    *@return Object=>resultSet; :
    */
    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
    /**
    * Проверка пользователя на логин
    *@param login
    *@return bool=>true; :
    */
    public function checkUser($login)
    {
        $arr = array();
        $resultSet = $this->tableGateway->select();
        foreach ($resultSet as $key => $value) {                        
            array_push($arr, $value->login);
        }
        if(in_array($login, $arr)){
            return false;
        }
        return true;
    }
    /**
    * Получение пользователя по id
    *@param id
    *@return  $row; :
    */
    public function getUser($id)
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
    * Сохранение пользователя в БД
    *@param User
    */
    public function saveUser(User $user)
    {       

        $data = array(            
            'login' => $user->login,
            'email' => $user->email,            
            'password'  => $user->password,            
        ); 
        if(isset($user->role)){
            $data['role'] = $user->role;  
        }         
        $id = (int)$user->id;
        if ($id == 0) {             
            $this->tableGateway->insert($data);
        } else {
            $data['active'] = $user->active;           
            $data['logged'] = $user->logged;         
            if ($this->getUser($id)) {
               $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }
    /**
    * Удаление пользователя
    *@param id
    */
    public function deleteUser($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }

    /**
    * Получение всех пользователей
    *@return Object=>resultSet; :
    */
    public function getUserByLogin($login)
    {
        $where = array("login"=>$login);
        $resultSet = $this->tableGateway->select($where);
        $row = $resultSet->current();
        return $row;
    }
}