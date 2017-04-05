<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Administer;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;  
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Administer\Model\User;
use Administer\Model\UsersTable;

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
    // public function getServiceConfig()
    // {
    //     return array(
    //         'factories' => array(
    //             'AdministerModelUsersTable' =>  function($sm) {
    //                 $tableGateway = $sm->get('UsersTableGateway');
    //                 $table = new UsersTable($tableGateway);
    //                 return $table;
    //             },
    //             'UsersTableGateway' => function ($sm) {
    //                 $dbAdapter = $sm->get('ZendDbAdapterAdapter'); // Подключение к БД
    //                 $resultSetPrototype = new ResultSet();
    //                 $resultSetPrototype->setArrayObjectPrototype(new User());
    //                 return new TableGateway('users', $dbAdapter, null, $resultSetPrototype);
    //             },
    //         ),
    //     );
    // }
}
