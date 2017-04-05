<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Acl;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    protected $router;
    protected $response;
    public function onBootstrap(MvcEvent $e)
    {
        $this -> initAcl($e);
        $e -> getApplication() -> getEventManager() -> attach('route', array($this, 'checkAcl'));
        $this->router = $e->getRouter();
        $this->response = $e->getResponse();

    }
    /**
    *Автозагрузчик
    *@return array
    */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    /**
    * Получение роли пользователя
    *@param MvcEvent
    *@return роль пользователя
    */
    public function getRoleUser(MvcEvent $e){

        $serviceManager = $e->getApplication()->getServiceManager();
        $authService =  $serviceManager->get('AuthService');
        if($authService->hasIdentity()){
            $userInfo = $authService->getIdentity();

            return $userInfo->role; 
            // return "guest";          
        }else{
            return "guest";
        }
    }
    /**
    * Получение всех ресурсов
    *@param MvcEvent
    *@return array
    */
    public function getResource(MvcEvent $e){
        $serviceManager = $e->getApplication()->getServiceManager();
        $resourceService =  $serviceManager->get('AccessModelResourcesTable');
        $resources = $resourceService->fetchAll();
        $arrResources = [];
        foreach ($resources as $key => $value) {
            $arrResources[$value->id] = $value->resource_name;          
        }
        return  $arrResources;
    }
    /**
    * Получение всех ролей
    *@param MvcEvent
    *@return array
    */
    public function getRoles(MvcEvent $e){
        $serviceManager = $e->getApplication()->getServiceManager();
        $rolesService =  $serviceManager->get('AccessModelRolesTable');
        $roles = $rolesService->fetchAll();
        $arrRoles = [];
        foreach ($roles as $key => $value) {
            $arrRoles[$value->id] = $value->role_name;          
        }        
        return  $arrRoles;        
    }
    /**
    * Получение всех доступов
    *@param MvcEvent
    *@return array
    */
    public function getAccess(MvcEvent $e){
        $serviceManager = $e->getApplication()->getServiceManager();
        $accessService =  $serviceManager->get('AccessModelAccessTable');
        $access = $accessService->fetchAll();
        $arrAccess = [];
     
        foreach ($access as $key => $value) {
            $arrAccess[$value->id]['id_role'] = $value->id_role; 
            $arrAccess[$value->id]['id_resource'] = $value->id_resource; 
            $arrAccess[$value->id]['access'] = $value->access;          
        }
        return  $arrAccess;
    }  
    /**
    * Присвоение роям доступные ресурсы
    *@param MvcEvent
    */
    public function initAcl(MvcEvent $e) {       
        $acl = new \Zend\Permissions\Acl\Acl(); 
        $arrResource = $this->getResource($e);
        $arrRoles = $this->getRoles($e);
        $arrAccess = $this->getAccess($e);

                    
        foreach ($arrResource as $resource) {        // Объявленеи ресурсов 
            if(!$acl ->hasResource($resource))
                $acl -> addResource(new \Zend\Permissions\Acl\Resource\GenericResource($resource));
        }
        foreach ($arrRoles as $role) {    // Объявление ролей
            $role = new \Zend\Permissions\Acl\Role\GenericRole($role);
            $acl -> addRole($role);
        }
        foreach ($arrAccess as $key => $value) {          // Работа с доступами         
            if($value["access"] == 1){
                $role = $arrRoles[$value['id_role']];
                $resource = $arrResource[$value['id_resource']];
                // echo "$role-"."$resource"."<br/>";
                $acl -> allow($role, $resource);           // Открытие доступа ресурса роли
            }
        } 
        //setting to view
        $e -> getViewModel() -> acl = $acl;
    }
    /**
    * Проверка прав
    *@param MvcEvent
    */
    public function checkAcl(MvcEvent $e) {
        $route = $e -> getRouteMatch() -> getMatchedRouteName();
        //you set your role
        $userRole = $this->getRoleUser($e);        
        if (!$e -> getViewModel() -> acl -> isAllowed($userRole, $route)) {
            $url = $this->router->assemble(array(), array('name' => 'home'));
            $this->response->getHeaders()->addHeaderLine('Location', $url);
            $this->response->setStatusCode(302);
            $this->response->sendHeaders();
        }
    }
}