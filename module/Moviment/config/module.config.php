<?php
namespace Moviment;

use Zend\ServiceManager\Factory\InvokableFactory;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

return [
    'router' => [
        'routes' => [
            'moviment' => [
                'type'    => Segment::class,
                'options' => [
                    // Change this to something specific to your module
                    'route'    => '/moviment[/:action[/:id][/:codiB]]',
					'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-zA-Z0-9_-]*',
                        'codiB' => '[0-9]*',
                    ],
                    'defaults' => [
                        'controller'    => Controller\MovimentController::class,
                    ],
                ],
            ],
            'llista' => [
                'type'    => Segment::class,
                'options' => [
                    // Change this to something specific to your module
                    'route'    => '/llista/llistaxcompte[/:codiB]',
					'constraints' => [
                        'codiB' => '[0-9]*',
                    ],
                    'defaults' => [
                        'controller'    => Controller\MovimentController::class,
						'action' 		=> 'llistaxcompte',
                    ],
                ],
            ],
            'importar' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/importar[/:codiB]',
					'constraints' => [
                        'codiB' => '[0-9]*',
                    ],
                    'defaults' => [
                        'controller'    => Controller\ImportarController::class,
						'action' 		=> 'importar',
                    ],
                ],
            ],
        ],
    ],
	'controllers' => [
        'factories' => [
            Controller\MovimentController::class => Controller\Factory\MovimentControllerFactory::class,            
        ],
    ],
	// The 'access_filter' key is used by the Compte module to restrict or permit
    // access to certain controller actions for unauthorized visitors.
    'access_filter' => [
        'controllers' => [
            Controller\MovimentController::class => [
                // Give access to "message" actions
                // to anyone.
                ['actions' => ['message','llistaxcompte'], 'allow' => '*'],
                // Give access to "index", "add", "edit", "view" actions to authorized comptes only.
                ['actions' => ['index', 'add', 'edit', 'view'], 'allow' => '@']
            ],
        ]
    ],
	'service_manager' => [
        'factories' => [
			Service\MovimentManager::class => Service\Factory\MovimentManagerFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'Moviment' => __DIR__ . '/../view',
        ],
    ],
	'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Entity']
            ],
            'orm_conta' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ]
            ]
        ]
    ],
	'session_containers' => [
        'UserDatos'
    ],
];
