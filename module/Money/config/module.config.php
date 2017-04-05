<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'router' => array(
        'routes' => array(
           'money' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/money',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Money\Controller',
                        'controller'    => 'Index',
                        'action'        => 'costs',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                              ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                    // 'auth' => array(
                    //     'type'    => 'Literal',
                    //     'options' => array(
                    //         'route'    => '/auth',
                    //         'defaults' => array(
                    //             '__NAMESPACE__' => 'User\Controller',
                    //              'controller'    => 'Index',
                    //              'action'        => 'auth',
                    //         ),
                    //     ),
                    // ),                                                   
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Money\Controller\Index' => 'Money\Controller\IndexController',
            'Money\Controller\Profit' => 'Money\Controller\ProfitController'
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'money/index/index'        => __DIR__ . '/../view/money/index/index.phtml',
            'money/profit/profit'        => __DIR__ . '/../view/money/profit/profit.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'strategies' => array('ViewJsonStrategy',),
    ),

    

    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
