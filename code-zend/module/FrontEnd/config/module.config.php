<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'FrontEnd\Controller\Index' => 'FrontEnd\Controller\IndexController',
        ),
        'factories' => array(
            'FrontEnd\Controller\Post' => 'FrontEnd\Factory\PostControllerFactory',
            'FrontEnd\Controller\Test' => 'FrontEnd\Factory\TestControllerFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        'controller' => 'FrontEnd\Controller\Index',
                        'action' => 'index',
                    ),
                ),
            ),
            'post' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/post',
                    'defaults' => array(
                        'controller' => 'FrontEnd\Controller\Post',
                        'action' => 'index',
                    )
                ),
            ),
            'post-tab' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/post-tab',
                    'defaults' => array(
                        'controller' => 'FrontEnd\Controller\Post',
                        'action' => 'tab',
                    )
                ),
            ),
            'post-tab-district' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/post-tab/district',
                    'defaults' => array(
                        'controller' => 'FrontEnd\Controller\Post',
                        'action' => 'district',
                    )
                ),
            ),
            'post-tab-ward' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/post-tab/ward',
                    'defaults' => array(
                        'controller' => 'FrontEnd\Controller\Post',
                        'action' => 'ward',
                    )
                ),
            ),
            'post-tab-project-type' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/post-tab/parent-category',
                    'defaults' => array(
                        'controller' => 'FrontEnd\Controller\Post',
                        'action' => 'parentCategory',
                    )
                ),
            ),
            'post-tab-category' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/post-tab/category',
                    'defaults' => array(
                        'controller' => 'FrontEnd\Controller\Post',
                        'action' => 'category',
                    )
                ),
            ),
            'post-tab-feature' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/post-tab/features',
                    'defaults' => array(
                        'controller' => 'FrontEnd\Controller\Post',
                        'action' => 'feature'
                    )
                ),
            ),
            'post-save-post' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/post-tab/save-post',
                    'defaults' => array(
                        'controller' => 'FrontEnd\Controller\Post',
                        'action' => 'savePost'
                    )
                ),
            ),
            'post-upload-image' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/post-tab/upload-image',
                    'defaults' => array(
                        'controller' => 'FrontEnd\Controller\Post',
                        'action' => 'uploadImage'
                    )
                ),
            ),
            'test-unlink-image' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/test/unlink-image',
                    'defaults' => array(
                        'controller' => 'FrontEnd\Controller\Test',
                        'action' => 'index'
                    )
                ),
            ),
            'test-mobile-detect' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/test/mobile-detect',
                    'defaults' => array(
                        'controller' => 'FrontEnd\Controller\Test',
                        'action' => 'mobileDetect'
                    )
                ),
            ),
        ),
    ),
    // ViewManager configuration
    'view_manager' => array(
//        'display_not_found_reason' => true,
//        'display_exceptions' => true,
//        'not_found_template' => 'error/404',
//        'exception_template' => 'error/index',
        // Doctype with which to seed the Doctype helper
        'doctype' => 'HTML5',
        // e.g. HTML5, XHTML1

        // Layout template name
        'layout' => \FrontEnd\Module::LAYOUT,
        // e.g. 'layout/layout'

        // TemplateMapResolver configuration
        // template/path pairs
        'template_map' => array(
            \FrontEnd\Module::LAYOUT => __DIR__ . '/../view/layout/fontend.phtml',
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
            'adapter' => function($sm){
                /** @var \Zend\ServiceManager\ServiceManager $sm */
                $config = $sm->get('config');
                return new \Zend\Db\Adapter\Adapter($config['db']);
            }
        ),
    ),
);
