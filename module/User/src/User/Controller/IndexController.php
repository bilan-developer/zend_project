<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use User\Form\RegForm;
use User\Model\RegValid;
use User\Model\RegValidRequired;
use User\Model\User;
use User\Model\History;
use User\Form\LogoutForm;
use User\Model\LogoutValid;
use User\Storage\AuthStorage;

class IndexController extends AbstractActionController
{
    public $usersTable;
    public $historyTable;
    protected $costsTable;
    protected $shoppingListTable;    
    protected $profitTable;       
    protected $authService;
    protected $storage;
    protected $name_resource;
  
    /**
    * Регистрация
    *@return ViewModel():
    */   
    public function registrationAction(){
        $error = [];
        $arr  = array();
        $form = new RegForm;
        $form->prepareElements();
        $request = $this->getRequest();
        if ($request->isPost()) { 
            $validator = new RegValidRequired;
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
                        $this->getAuthService()->getAdapter()
                                    ->setIdentity($request->getPost('login'))
                                    ->setCredential($request->getPost('password'));
                        $authResult = $this->getAuthService()->authenticate();       
                        
                        $authService = $this->getAuthService();               
                        $resultRow = $this->getAuthService()->getAdapter()->getResultRowObject(array("id","login","role","active","logged","password"));                        
                        $this->getSessionStorage()->setRememberMe(1); 
                        $this->getAuthService()->setStorage($this->getSessionStorage());
                        $authService->getStorage()->write($resultRow);
                        /*Запись history*/                            
                        $this->addHistory($resultRow->id); 
                        $this->redirect()->toRoute('user/auth', array('controller'=> 'index', 'action'=>'auth'));
                    }else{
                        $error['0'] = "Пользователь с таким логином существует"; 
                    }                   
                }else{
                    $error['0'] = "Не совпадает повторный пароль"; 
                }                
            }
            return array('form' => $form, 'error' => $error);
        }else{           
            $view = new ViewModel([
                'form' => $form,
                'error' => $error
            ]);
            return $view;
        }
    }    
    /**
    * Авторизация
    *@param
    *@return ViewModel():
    */  
    public function authAction(){
        $form = new LogoutForm;
        $form->prepareElements();
        $request = $this->getRequest();
        $authService = $this->getAuthService();        
        if ($request->isPost()) { 
            $validator = new LogoutValid;
            $form->setInputFilter($validator->getInputFilter());
            $val = $form->getInputFilter()->setData($request->getPost())->getValues(); $form->setData($val);
            $result = $authService->getIdentity();
            if ($form->isValid()) { 
                if (!$authService->hasIdentity()) {
                    $this->getAuthService()->getAdapter()
                         ->setIdentity($request->getPost('login'))
                         ->setCredential(($request->getPost('password')));
                    $authResult = $this->getAuthService()->authenticate();
                    if ($authResult->isValid()) {
                       $resultRow = $this->getAuthService()->getAdapter()->getResultRowObject(array("id","login","role","active","logged","password"));
                        if($request->getPost('checkbox')){                        
                            $this->getSessionStorage()->setRememberMe(1); 
                        }  
                        $this->getSessionStorage()->setRememberMe(0); 
                        $this->getAuthService()->setStorage($this->getSessionStorage());
                        $authService->getStorage()->write($resultRow);
                        /*Запись history*/                            
                        $this->addHistory($resultRow->id);
                        $user = $this->getUsersTable()->getUser($resultRow->id);
                        $user->logged = 1;
                        $result = $authService->getIdentity();
                        $sum = $this->totalSum($user->id);                        
                        $this->getUsersTable()->saveUser($user);                      
                        $view = new ViewModel([
                            'form' => $form, 
                            'result' => $result,
                            'sum' => $sum,
                        ]);
                        return $view;
                    }else{                        
                        $error = $authResult->getMessages();// ошибки при аторизации
                        $view = new ViewModel([
                            'form' => $form, 
                            'error' => $error,
                            'result' => $result,
                        ]);
                        return $view;
                    }
                }else{
                    $sum = $this->totalSum($result->id);                   
                    $view = new ViewModel([                        
                        'result' => $result,
                        'sum' => $sum,
                    ]);
                    return $view;
                    }
        }else{ 
            $result = $authService->getIdentity();
            $view = new ViewModel([
                'form' => $form,
                'result' => $result,
            ]);
            return $view;
        }
    }else{
        $result = $authService->getIdentity();
        if($result){
            $sum = $this->totalSum($result->id);
            $view = new ViewModel([
                'form' => $form,
                'result' => $result,
                'sum' => $sum,
            ]);
            return $view;
        }else{
            $view = new ViewModel([
                'form' => $form,
                'result' => $result,                
            ]);
            return $view;
        }
        
       
        

    }
}
    /**
    * Редактирование
    *@param GET[id]
    *@return ViewModel():
    */  
    public function editAction(){
        if($this->getRequest()->isGet())
        {             
            $id = $this->getRequest()->getQuery();            
            $user = $this->getUsersTable()->getUser($id->id); 
        }             
        $form = new RegForm();
        $form->prepareElements();
        $request = $this->getRequest();
        $authService = $this->getAuthService();
        $userInfo = $authService->getIdentity();
        if ($request->isPost()) {                     
            $pas = $request->getPost('password');                
            $pasR = $request->getPost('rep_password');
            $login = $request->getPost('login');
            if( ($pas == "") && ($pasR == "")){
                $pas = $userInfo->password;                
                $pasR = $userInfo->password;                           
            }
            $validator = new RegValid;
            $form->setInputFilter($validator->getInputFilter());
            $val = $form->getInputFilter()->setData($request->getPost())->getValues(); 
            $form->setData($val);
            if ($form->isValid()) {
                if($pas===$pasR){                                        
                    $checkUser = $this->getUsersTable()->checkUser($login);                    
                    $authService = $this->getAuthService();
                    $userInfo = $authService->getIdentity();
                    $userLogin = $userInfo->login;
                    if( ($checkUser) || ($userLogin == $login) ){
                        $user = new User();
                        $user->exchangeArray($form->getData());
                        $user->password = $pas;
                        $user->role = $userInfo->role;
                        $user->active = $userInfo->active;                        
                        $user->logged = 1;         
                        $this->getUsersTable()->saveUser($user);
                        $this->getAuthService()->getAdapter()
                                    ->setIdentity($request->getPost('login'))
                                    ->setCredential($pas);
                        $authResult = $this->getAuthService()->authenticate();
                        $authService = $this->getAuthService();          
                        $resultRow = $this->getAuthService()->getAdapter()->getResultRowObject(array("id","login","role","active","logged","password")); 
                        $this->getSessionStorage()->setRememberMe(1); 
                        $this->getAuthService()->setStorage($this->getSessionStorage());
                        $authService->getStorage()->write($resultRow);                        
                        return $this->redirect()->toRoute('user/auth', array('controller'=>'index', 'action'=>'auth'));
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
            }else{ 
                $view = new ViewModel([
                    'form' => $form,                    
                ]);
                return $view; 
            }             
        }
        else{
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
    /**
    * Выход пользователя из системы
    *@return $this->redirect()
    */  
    public function exitAction(){
        $authService = $this->getAuthService();
        $userInfo = $authService->getIdentity();
        $userId = $userInfo->id;
        $user = $this->getUsersTable()->getUser($userId); 
        $user->logged = 0; 
        $user = $this->getUsersTable()->saveUser($user);       
        $this->getSessionStorage()->forgetMe();  
        $this->getAuthService()->clearIdentity();
        return $this->redirect()->toRoute('user/auth', array('controller'=> 'index', 'action'=>'auth')); // Редирект на форму авторизации 
       
   
    }
    /**
    * Выход пользователя из онлайна
    **@param GET[id]
    *@return bool=>true
    */ 
    public  function logoutAction() {
        if($this->getRequest()->isGet())
        {             
            $id = $this->getRequest()->getQuery();        
            $user = $this->getUsersTable()->getUser($id->id); 
            $user->logged = 0; 
            $user = $this->getUsersTable()->saveUser($user);
            return true;  
        }else{return false; } 
    } 
    
    /**
    * История посещений
    *@param GET[id]
    *@return ViewModel:
    */  
    public function historyAction(){
        if($this->getRequest()->isGet())
        {  
            $id = $this->getRequest()->getQuery();
            $history = $this->getHistoryTable()->getHistory($id->id);            
            $view = new ViewModel([
                'history' => $history,
            ]);
            return $view;
        } 
    }
    /**
    * Активация пользователя
    **@param GET[id]
    *@return ViewModel:
    */
    public function activationLinkAction(){
        if($this->getRequest()->isGet())
        {  
            $id = $this->getRequest()->getQuery();
            $user = $this->getUsersTable()->getUser($id->id);
            $user->active = 1; 
            $this->getUsersTable()->saveUser($user);                     
            $this->redirect()->toRoute('user/default', array('controller'=> 'index', 'action'=>'exit'));
            return;
        } 
    }
    /**
    * Запись истории
    *@return bool=>true; :
    */
    public function addHistory($id_user){
        $history = new History();
        $history->date = date("Y-m-d:h:i:s");
        $history->ip = $_SERVER['REMOTE_ADDR'];
        $history->id_user = $id_user;                      
        $this->getHistoryTable()->saveHistory($history);
        return true; 
    }
    /**
    * Связь с AuthService
    *@return authService; :
    */
    public function getAuthService(){
        if(!$this->authService){
            $this->authService = $this->getServiceLocator()->get('AuthService');
        }
        return $this->authService;
    }
    /**
    * Инициализация хранилища AuthStorage
    *@return storage; :
    */
    public function getSessionStorage(){
        if(!$this->storage){
            $this->storage = $this->getServiceLocator()->get('User\Storage\AuthStorage'); 
        }
        return $this->storage;
    }
    /**
    * Инициализация таблицы UsersTable
    *@return usersTable; :
    */
    public function getUsersTable(){
        if (!$this->usersTable) 
        {
            $sm = $this->getServiceLocator();
            $this->usersTable = $sm->get('User\Model\UsersTable');
        }
        return $this->usersTable;
    }
    /**
    * Инициализация таблицы ShoppingList
    *@return $this->shoppingListTable;
    */   
    public function getShoppingListTable(){
        if (!$this->shoppingListTable) 
        {
            $sm = $this->getServiceLocator();
            $this->shoppingListTable = $sm->get('Money\Model\ShoppingListTable');
        }
        return $this->shoppingListTable;
    }
    /**
    * Инициализация таблицы Costs
    *@return $this->costsTable;
    */  
    public function getCostsTable(){
        if (!$this->costsTable) 
        {
            $sm = $this->getServiceLocator();
            $this->costsTable = $sm->get('Money\Model\CostsTable');
        }
        return $this->costsTable;
    }
    /**
    * Инициализация таблицы Profit
    *@return $this->profitTable;
    */  
    public function getProfitTable(){
        if (!$this->profitTable) 
        {
            $sm = $this->getServiceLocator();
            $this->profitTable = $sm->get('Money\Model\ProfitTable');
        }
        return $this->profitTable;
    }
     /**
    * Инициализация таблицы HistoryTable
    *@return historyTable; :
    */
    public function getHistoryTable(){
        if (!$this->historyTable) 
        {
            $sm = $this->getServiceLocator();
            $this->historyTable = $sm->get('User\Model\HistoryTable');
        }
        return $this->historyTable;
    }
    /**
    * Подсчёт конечного остатка
    *@param $id
    *@return $resultSum; :
    */
    public function totalSum($id){
        $profitSum = 0;
        $costSum = 0;
        $shoppingList = $this->getShoppingListTable()->getShoppingListIdUser($id);
        $cost = $this->getCostsTable()->getCostsIdUser($id);
        $profit = $this->getProfitTable()->getProfitIdUser($id);
        foreach ($shoppingList as $key => $value) {
            if($value->status == 1){
                $costSum += $value->sum;
            }
        }
        foreach ($cost as $key => $value) {
            $costSum += $value->sum;
        }
        foreach ($profit as $key => $value) {
            $profitSum += $value->sum;
        }
        $resultSum = $profitSum - $costSum;        
        return $resultSum;
    }
    /**
    * Авторизация с помощью ВК
    *@param GET
    *@return $ViewModel; :
    */
    // public function authVkAction(){        
    //     $request = $this->getRequest();
    //     $authService = $this->getAuthService();        
    //     if ($request->getQuery()) { 
    //         if (!$authService->hasIdentity()) {
    //             var_dump($request->getQuery());
    //             $user = $this->getUsersTable()->getUserByLogin($request->getQuery("uid"));
    //             if(!$user){
    //                 $newUser = new User();
    //                 $dataArray = [
    //                     "login"=> $request->getQuery("uid"),
    //                     "password"=> $request->getQuery("hash"),
    //                     "email"=>$request->getQuery("first_name")
    //                 ];
    //                 $newUser->exchangeArray($dataArray);
    //                 $this->getUsersTable()->saveUser($newUser);
    //                 $user = $this->getUsersTable()->getUserByLogin($request->getQuery("uid"));
    //             }
    //             $this->getAuthService()->getAdapter()
    //                  ->setIdentity($request->getQuery("uid"))
    //                  ->setCredential(($request->getQuery("hash")));
    //             $authResult = $this->getAuthService()->authenticate();
    //             if ($authResult->isValid()) {
    //                $resultRow = $this->getAuthService()->getAdapter()->getResultRowObject(array("id","login","role","active","logged","password"));
    //                 if($request->getPost('checkbox')){                        
    //                     $this->getSessionStorage()->setRememberMe(1); 
    //                 }  
    //                 $this->getSessionStorage()->setRememberMe(0); 
    //                 $this->getAuthService()->setStorage($this->getSessionStorage());
    //                 $authService->getStorage()->write($resultRow);
    //                 /*Запись history*/                            
    //                 $this->addHistory($resultRow->id);
    //                 $user = $this->getUsersTable()->getUser($resultRow->id);
    //                 $user->logged = 1;
    //                 $result = $authService->getIdentity();
    //                 $sum = $this->totalSum($user->id);                        
    //                 $this->getUsersTable()->saveUser($user);                      
    //                 $view = new ViewModel([
    //                     'form' => $form, 
    //                     'result' => $result,
    //                     'sum' => $sum,
    //                 ]);
    //                 $view->setTemplate("/user/index/auth");
    //                 return $view;
    //             }else{                        
    //                 $error = $authResult->getMessages();// ошибки при аторизации
    //                 $view = new ViewModel([
    //                     'form' => $form, 
    //                     'error' => $error,
    //                     'result' => $result,
    //                 ]);
    //                 $view->setTemplate("/user/index/auth");
    //                 return $view;
    //             }
 
    //         } 
    //     }
    // }       
}

