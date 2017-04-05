<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Access;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Access\Model\Role;
use Access\Model\RolesTable;
use Access\Model\Resource;
use Access\Model\ResourcesTable;
use Access\Model\Access;
use Access\Model\AccessTable;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Zend\Authentication\Adapter\DbTable\CredentialTreatmentAdapter as DbTableAuthAdapter; // Краткое обращение
use Zend\Authentication\Storage;
use Zend\Authentication\AuthenticationService;
use Access\Storage\AuthStorage;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

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
    public function getServiceConfig()
    {
        return array(
            'factories' => array(               
                'AccessModelRolesTable' =>  function($sm) {
                    $tableGateway = $sm->get('RolesTableGateway');
                    $table = new RolesTable($tableGateway);
                    return $table;
                },
                'RolesTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend/Db/Adapter/Adapter'); // Подключение к БД
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Role());
                    return new TableGateway('role', $dbAdapter, null, $resultSetPrototype);
                },
                'AccessModelResourcesTable' =>  function($sm) {
                    $tableGateway = $sm->get('ResourcesTableGateway');
                    $table = new ResourcesTable($tableGateway);
                    return $table;
                },
                'ResourcesTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend/Db/Adapter/Adapter'); // Подключение к БД
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Resource());
                    return new TableGateway('resources', $dbAdapter, null, $resultSetPrototype);
                },
                'AccessModelAccessTable' =>  function($sm) {
                    $tableGateway = $sm->get('AccessTableGateway');
                    $table = new AccessTable($tableGateway);
                    return $table;
                },
                'AccessTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend/Db/Adapter/Adapter'); // Подключение к БД
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Access());
                    return new TableGateway('role_access', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }
}
