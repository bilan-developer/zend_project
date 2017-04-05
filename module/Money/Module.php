<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Money;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Zend\Authentication\Adapter\DbTable\CredentialTreatmentAdapter as DbTableAuthAdapter; // Краткое обращение;
use Zend\Authentication\AuthenticationService;
use Money\Model\Category;
use Money\Model\CategoryTable;
use Money\Model\Costs;
use Money\Model\CostsTable;
use Money\Model\ShoppingList;
use Money\Model\ShoppingListTable;
use Money\Model\Goods;
use Money\Model\GoodsTable;

use Money\Model\CategoryProfit;
use Money\Model\CategoryProfitTable;

use Money\Model\Profit;
use Money\Model\ProfitTable;

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
                'MoneyModelCategoryTable' =>  function($sm) {
                    $tableGateway = $sm->get('CategoryTableGateway');
                    $table = new CategoryTable($tableGateway);
                    return $table;
                },
                'CategoryTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('ZendDbAdapterAdapter'); // Подключение к БД
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Category());
                    return new TableGateway('category', $dbAdapter, null, $resultSetPrototype);
                },   
                'MoneyModelCostsTable' =>  function($sm) {
                    $tableGateway = $sm->get('CostsTableGateway');
                    $table = new CostsTable($tableGateway);
                    return $table;
                },
                'CostsTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('ZendDbAdapterAdapter'); // Подключение к БД
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Costs());
                    return new TableGateway('costs', $dbAdapter, null, $resultSetPrototype);
                }, 
                'MoneyModelShoppingListTable' =>  function($sm) {
                    $tableGateway = $sm->get('ShoppingListTableGateway');
                    $table = new ShoppingListTable($tableGateway);
                    return $table;
                },
                'ShoppingListTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('ZendDbAdapterAdapter'); // Подключение к БД
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new ShoppingList());
                    return new TableGateway('shopping_list', $dbAdapter, null, $resultSetPrototype);
                }, 
                'MoneyModelGoodsTable' =>  function($sm) {
                    $tableGateway = $sm->get('GoodsTableGateway');
                    $table = new GoodsTable($tableGateway);
                    return $table;
                },
                'GoodsTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('ZendDbAdapterAdapter'); // Подключение к БД
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Goods());
                    return new TableGateway('goods', $dbAdapter, null, $resultSetPrototype);
                }, 
                'MoneyModelCategoryProfitTable' =>  function($sm) {
                    $tableGateway = $sm->get('CategoryProfitTableGateway');
                    $table = new CategoryProfitTable($tableGateway);
                    return $table;
                },
                'CategoryProfitTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('ZendDbAdapterAdapter'); // Подключение к БД
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new CategoryProfit());
                    return new TableGateway('category_profit', $dbAdapter, null, $resultSetPrototype);
                }, 
                'MoneyModelProfitTable' =>  function($sm) {
                    $tableGateway = $sm->get('ProfitTableGateway');
                    $table = new ProfitTable($tableGateway);
                    return $table;
                },
                'ProfitTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('ZendDbAdapterAdapter'); // Подключение к БД
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Profit());
                    return new TableGateway('profit', $dbAdapter, null, $resultSetPrototype);
                },                                                              
            ),
        );
    }
}
