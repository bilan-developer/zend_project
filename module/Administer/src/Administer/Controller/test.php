<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Administer\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use User\Model\User;
use User\Form\RegForm;
use User\Model\RegValid;

class IndexController extends AbstractActionController
{
    protected $usersTable;
    /**
    * Инициализация таблицы Users
    *@return $this->usersTable
    */  
    public function getUsersTable()
    {
        if (!$this->usersTable) {
            $sm = $this->getServiceLocator();
            $this->usersTable = $sm->get('UserModelUsersTable');
        }
        return $this->usersTable;
    }
    /**
    * Список всех пользователей
    *@return ViewModel
    */  
    public function userAction(){
        $users = $this->getUsersTable()->fetchAll();        
        $view = new ViewModel(array(
            'users' => $users,
        ));
        return $view;
    }
    /**
    * Удаление пользователя
    *@param GET[id]
    *@return $this->redirect()
    */  
    public function deleteAction(){
        if($this->getRequest()->isGet()){
            $id = $this->getRequest()->getQuery();            
            $this->getUsersTable()->deleteUser($id['id']);
            return $this->redirect()->toRoute('administer/default', array('controller'=> 'index', 'action'=>'user')); // Редирект на страницу всех пользоватлей
        }
    }
    /**
    * Добавление пользователя
    *@return ViewModel
    */  
    public function addUserAction(){
        $error = [];
        $arr  = array();
        $form = new RegForm;
        $form->prepareElements();
        $request = $this->getRequest();
        if ($request->isPost()) { 
            $validator = new RegValid;
            $form->setInputFilter($validator->getInputFilter());
            $val = $form->getInputFilter()->setData($request->getPost())->getValues(); 
            $form->setData($val);
            if ($form->isValid()) { 
                $pas = $request->getPost('password');                
                $pasR = $request->getPost('rep_password');
                $login = $request->getPost('login');
                if($pas===$pasR){
                    $checkUser = $this->getUsersTable()->checkUser($login);                    
                    if($checkUser){
                        $user = new User();
                        $user->exchangeArray($form->getData());
                        $this->getUsersTable()->saveUser($user);
                        return $this->redirect()->toRoute('administer/default', array('controller'=> 'index', 'action'=>'user'));
                    }else{
                        $error['0'] = "Пользователь с таким логином существует"; 
                        $view = new ViewModel([
                            'form' => $form,
                            'error' => $error
                        ]);
                        return $view;
                    }                   
                }else{
                    $error['0'] = "Не совпадает повторный пароль"; 
                    $view = new ViewModel([
                        'form' => $form,
                        'error' => $error
                    ]);
                    return $view;
                }                
            }else{
                return array('form' => $form, 'error' => $error);
            }            
        }else{           
            $view = new ViewModel([
                'form' => $form,
            ]);
            return $view;
        }
    }
    /**
    * Редактирование пользователя
    *@param GET[id]
    *@return ViewModel
    */  
    public function editUserAction(){
        if($this->getRequest()->isGet())
        {             
            $id = $this->getRequest()->getQuery();            
            $user = $this->getUsersTable()->getUser($id->id); 
        }       
        $form = new RegForm();
        $form->prepareElements();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $validator = new RegValid;
            $form->setInputFilter($validator->getInputFilter());
            $val = $form->getInputFilter()->setData($request->getPost())->getValues(); 
            $form->setData($val);
            if ($form->isValid()) { 
                $pas = $request->getPost('password');                
                $pasR = $request->getPost('rep_password');
                $login = $request->getPost('login');
                $id = $request->getPost('id');
                $user = $this->getUsersTable()->getUser($id); 
                $loginEditUser = $user->login;                
                if($pas===$pasR){                    
                    $checkUser = $this->getUsersTable()->checkUser($login);                   
                    if( ($checkUser) || ($loginEditUser == $login) ){                       
                        $user = new User();
                        $user->exchangeArray($form->getData());
                        $this->getUsersTable()->saveUser($user);                                             
                        return $this->redirect()->toRoute('administer/default', array('controller'=> 'index', 'action'=>'user'));
                    }else{
                        $error['0'] = "Пользователь с таким логином существует";
                        $view = new ViewModel([
                            'form' => $form,
                            'error' =>$error 
                        ]);
                        return $view;  
                    }                   
                }else{
                    $error['0'] = "Не совпадает повторный пароль"; 
                    $view = new ViewModel([
                        'form' => $form,
                        'error' =>$error 
                    ]);
                    return $view;                                       
                } 
                $view = new ViewModel([
                    'form' => $form,                    
                ]);
                return $view;                             
            }else{ 
                $view = new ViewModel([
                    'form' => $form,                    
                ]);
                return $view; 
            }             
        }else{
            $val['id'] = $user->id;
            $val['login'] = $user->login;
            $val['email'] = $user->email;            
            $val['password'] = $user->password;
            $val['rep_password'] = $user->password;
            $form->setData($val);
            $view = new ViewModel([
                'form' => $form,
            ]);
            return $view;
        }
    } 
}
