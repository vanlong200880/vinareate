<?php
return array(
    'router' => array(
        'routes' => array(
            'config-autoloaded' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/config/autoloaded',
                    'defaults' => array(
                        'controller' => 'Backend\Controller\IlluminateDatabase',
                        'action' => 'index'
                    ),
                ),
            ),
        ),
    )
);