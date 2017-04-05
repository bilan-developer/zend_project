<?php
namespace User\Model;
 
class User
{
    public $id;
    public $login;
    public $email;
    public $password;
    public $role;    
    public $active;
    public $logged;
    
    /**
    * Инициализация полей из таблицы пользователей
    *@param $data
    */ 
    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;
        $this->login = (isset($data['login'])) ? $data['login'] : null;
        $this->email  = (isset($data['email'])) ? $data['email'] : null;
        $this->password  = (isset($data['password'])) ? $data['password'] : null;
        $this->role  = (isset($data['role'])) ? $data['role'] : null;        
        $this->active  = (isset($data['active'])) ? $data['active'] : null; 
        $this->logged  = (isset($data['logged'])) ? $data['logged'] : null;  
         
    }
}