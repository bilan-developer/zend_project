<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace User;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use User\Model\User;
use User\Model\UsersTable;
use User\Model\History;
use User\Model\HistoryTable;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Zend\Authentication\Adapter\DbTable\CredentialTreatmentAdapter as DbTableAuthAdapter; // Краткое обращение
use Zend\Authentication\Storage;
use Zend\Authentication\AuthenticationService;
use User\Storage\AuthStorage;

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
                'User\Storage\AuthStorage' => function($sm){
                    return new AuthStorage('user'); // Создание хранилища
                },
                'AuthService' => function ($sm){
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter'); // подключение к БД
                    $dbTableAuthAdapter = new DbTableAuthAdapter($dbAdapter, 'users', 'login', 'password'); // Инициализация подключения название таблици поле логина и пароля

                    $authService = new AuthenticationService(); // инициализаци сервиса AuthenticationService
                    $authService->setAdapter($dbTableAuthAdapter);
                    $authService->setStorage($sm->get('User\Storage\AuthStorage')); // указываем место хранения данных
                    return $authService;
                },
                'UserModelUsersTable' =>  function($sm) {
                    $tableGateway = $sm->get('UsersTableGateway');
                    $table = new UsersTable($tableGateway);
                    return $table;
                },
                'UsersTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('ZendDbAdapterAdapter'); // Подключение к БД
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new User());
                    return new TableGateway('users', $dbAdapter, null, $resultSetPrototype);
                },
                'UserModelHistoryTable' =>  function($sm) {
                    $tableGateway = $sm->get('HistoryTableGateway');
                    $table = new HistoryTable($tableGateway);
                    return $table;
                },
                'HistoryTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('ZendDbAdapterAdapter'); // Подключение к БД
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new History());
                    return new TableGateway('history', $dbAdapter, null, $resultSetPrototype);
                },                     
            ),
        );
    }
}
