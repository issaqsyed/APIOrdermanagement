<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Ordermanagement\Controller\Ordermanagement' => 'Ordermanagement\Controller\OrdermanagementController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'ordermanagement' => array(
                'type'    => 'Segment',
                'options' => array(
                    // How to call this Action Through URL                 
                    'route'    => '/ordermanagement[/][:action][/:id][/:id1]',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Ordermanagement\Controller',
                        'controller'    => 'Ordermanagement',
                        'action'        => 'index',
                    ),
                ),
             
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Ordermanagement' => __DIR__ . '/../view',
        ),
        // Added : so to use Json in this Module.
        'strategies' => array (           
                'ViewJsonStrategy',
        ),
    ),
   
);




