<?php
return array(
	'controllers' => array(
		'invokables' => array(
			'ApiorderManagement\Controller\ApiorderManagement' => 'ApiorderManagement\Controller\ApiorderManagementController',
		),
	),
	 'router' => array(
		'routes' => array(
			'order-rest' => array(
				'type' => 'segment',
				'options' => array(
					'route' => '/order-rest[/:id]',
					'constraints' => array(
						'id' => '[0-9]+',
					),
					'defaults' => array(
						'controller' => 'ApiorderManagement\Controller\ApiorderManagement',
					),
				),
			),
		),
	),
	 
	'view_manager' => array(
		'strategies' => array(
			'ViewJsonStrategy',
		),
	),
);