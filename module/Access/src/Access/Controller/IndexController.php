<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Access\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class IndexController extends AbstractActionController
{
    protected $roleTable;
    protected $resourcesTable;
    protected $accessTable;
    protected $name_resource;

    /**
    * Экшен страницы
    *@return ViewModel
    */     
    public function pageOneAction()
    {
        return new ViewModel();
    }
    /**
    * Экшен страницы
    *@return ViewModel
    */   
    public function pageTwoAction()
    {
        return new ViewModel();
    }
    /**
    * Экшен страницы
    *@return ViewModel
    */   
    public function pageThreeAction()
    {
        return new ViewModel();
    }
    /**
    * Инициализация таблицы Access
    *@return $this->accessTable;
    */  
    public function getAccessTable()
    {
        if (!$this->accessTable) {
            $sm = $this->getServiceLocator();
            $this->accessTable = $sm->get('Access\Model\AccessTable');
        }
        return $this->accessTable;
    } 
    /**
    * Инициализация таблицы Resources
    *@return $this->resourcesTable;
    */  
    public function getResourcesTable()
    {
        if (!$this->resourcesTable) {
            $sm = $this->getServiceLocator();
            $this->resourcesTable = $sm->get('Access\Model\ResourcesTable');
        }
        return $this->resourcesTable;
    } 
    /**
    * Инициализация таблицы Role
    *@return $this->roleTable;
    */ 
    public function getRoleTable()
    {
        if (!$this->roleTable) {
            $sm = $this->getServiceLocator();
            $this->roleTable = $sm->get('Access\Model\RolesTable');
        }
        return $this->roleTable;
    }   
    /**
    * Вывод ролей
    *@return ViewModel
    */  
    public function officeAdministratorAction() {
        $role = $this->getRoleTable()->fetchAll();        
        $view = new ViewModel(array(
            'role' => $role,
        ));
        return $view;
    }
    /**
    * Работа с доступами
    *@param GET[id]
    *@param GET[role_name]
    *@return ViewModel
    */  
    public function officeAction(){
       if ($this->getRequest()->isGet()) {
            $id_role = $this->getRequest()->getQuery('id');
            $role_name = $this->getRequest()->getQuery('role_name');
            $access = $this->getAccessTable()->getAccess($id_role);  
            $access1 = $this->getAccessTable()->getAccess($id_role);         
            $name_resource = $this->getResourcesTable()->getNameResource($access1); 
            $view = new ViewModel(array(
                'access' => $access,
                'name_resource' => $name_resource,
                'role_name'=> $role_name
            ));
            return $view;
        }
    }
    /**
    * Закрытие доступа
    *@param GET[id_role]
    *@param GET[id_resource]
    */ 
    public function closeAction(){
       if ($this->getRequest()->isGet()) { 
            $id_role = $this->getRequest()->getQuery('id_role');
            $id_resource = $this->getRequest()->getQuery('id_resource');
            $val = $this->getAccessTable(); 
            $access = $val->closeAccess($id_role, $id_resource);            
            $access->access = "0";
            $this->getAccessTable()->saveAccess($access);           
             $this->redirect()->toRoute('access/default', array('controller' => 'index', 'action' => 'office-administrator'));           
        }
    }
    /**
    * Открытие доступа
    *@param GET[id_role]
    *@param GET[id_resource]
    */ 
     public function openAction(){
       if ($this->getRequest()->isGet()) { 
            $id_role = $this->getRequest()->getQuery('id_role');
            $id_resource = $this->getRequest()->getQuery('id_resource');            
            $val = $this->getAccessTable();             
            $access = $val->closeAccess($id_role, $id_resource); 
            $access->access = "1";
            $this->getAccessTable()->saveAccess($access);
            $this->redirect()->toRoute('access/default', array('controller' => 'index', 'action' => 'office-administrator'));
        }
    }    
}
