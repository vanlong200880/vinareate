<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'BackEnd\Controller\Index' => 'BackEnd\Controller\IndexController',
        ),
        "factories" => array(
            'BackEnd\Controller\Province' => 'BackEnd\Factory\ProvinceControllerFactory',
        )
    ),
  'router' => array(
        'routes' => array(
            'backend' => array(
                'type' => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route' => '/backend',
                    'defaults' => array(
                        'controller' => 'Backend\Controller\Index',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'province' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/province[/:action[/:id]]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*'
                            ),
                             'defaults' => array(
                                'controller' => 'Backend\Controller\Province',
                                'action' => 'index',
                    ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    // ViewManager configuration
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
//        'not_found_template' => 'error/404',
//        'exception_template' => 'error/index',
        // Doctype with which to seed the Doctype helper
        'doctype' => 'HTML5',
        // e.g. HTML5, XHTML1

        // Layout template name
        'layout' => \BackEnd\Module::LAYOUT,
        // e.g. 'layout/layout'

        // TemplateMapResolver configuration
        // template/path pairs
        'template_map' => array(
            \BackEnd\Module::LAYOUT => __DIR__ . '/../view/layout/backend.phtml',
//            'error/404' => __DIR__ . '/../view/error/404.phtml',
//            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ),

        // TemplatePathStack configuration
        // module/view script path pairs
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        // Additional strategies to attach
        // These should be class names or service names of View strategy classes
        // that act as ListenerAggregates. They will be attached at priority 100,
        // in the order registered.
        'strategies' => array(
            'ViewJsonStrategy',
            // register JSON renderer strategy
            'ViewFeedStrategy',
            // register Feed renderer strategy
        ),
        
    ),
    'service_manager' => array(
        'factories' => array(
            'adapter' => function($sm) {
                /** @var \Zend\ServiceManager\ServiceManager $sm */
                $config = $sm->get('config');
                return new \Zend\Db\Adapter\Adapter($config['db']);
            }
        ),
    ),
);
