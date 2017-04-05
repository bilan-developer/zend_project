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
            'access' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/access',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Access\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
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
                    'auth' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/auth',
                            'defaults' => array(
                                '__NAMESPACE__' => 'Access\Controller',
                                 'controller'    => 'Index',
                                 'action'        => 'auth',
                            ),
                        ),
                    ),
                    'page-one' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/page-one',
                            'defaults' => array(
                                '__NAMESPACE__' => 'Access\Controller',
                                 'controller'    => 'Index',
                                 'action'        => 'page-one',
                            ),
                        ),
                    ),
                    'page-two' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/page-two',
                            'defaults' => array(
                                '__NAMESPACE__' => 'Access\Controller',
                                 'controller'    => 'Index',
                                 'action'        => 'page-two',
                            ),
                        ),
                    ),
                    'page-three' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/page-three',
                            'defaults' => array(
                                '__NAMESPACE__' => 'Access\Controller',
                                 'controller'    => 'Index',
                                 'action'        => 'page-three',
                            ),
                        ),
                    ),
                    'office-administrator' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/office-administrator',
                            'defaults' => array(
                                '__NAMESPACE__' => 'Access\Controller',
                                 'controller'    => 'Index',
                                 'action'        => 'office-administrator',
                            ),
                        ),
                    ),
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
            'Access\Controller\Index' => 'Access\Controller\IndexController'
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
            'access/index/index'        => __DIR__ . '/../view/access/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'strategies' => array('ViewJsonStrategy',),
    ),

    'view_helpers' => array(  
      'invokables'=> array( 
            'RenderForm' => 'Access\View\Helper\RenderFormHelper'       
         )  
     ),

    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
