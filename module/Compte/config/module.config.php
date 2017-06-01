<?php
namespace Compte;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

return [
    'router' => [
        'routes' => [
            'comptes' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/comptes/:persona[/:action[/:id]]',
                    'constraints' => [
                        'persona' => '[a-zA-Z]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-zA-Z0-9_-]*',
                    ],
                    'defaults' => [
                        'persona'        => 'g',
                        'controller'    => Controller\CompteController::class,
                        'action'        => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\CompteController::class => Controller\Factory\CompteControllerFactory::class,            
        ],
    ],
    // The 'access_filter' key is used by the Compte module to restrict or permit
    // access to certain controller actions for unauthorized visitors.
    'access_filter' => [
        'controllers' => [
            Controller\CompteController::class => [
                // Give access to "message" actions
                // to anyone.
                ['actions' => ['message'], 'allow' => '*'],
                // Give access to "index", "add", "edit", "view" actions to authorized comptes only.
                ['actions' => ['index', 'add', 'edit', 'view'], 'allow' => '@']
            ],
        ]
    ],
    'service_manager' => [
        'factories' => [
            Service\CompteManager::class => Service\Factory\CompteManagerFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
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
	'translator' => [
		'translation_file_patterns' => [
			[
				'type'     => 'gettext',
				'base_dir' => __DIR__ . '/../language',
				'pattern'  => '%s.mo',
			],
		],
	],
];
