<?php
namespace Traductor;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
	'service_manager' => [
        'factories' => [
            Controller\Plugin\TraductorPlugin::class => Controller\Plugin\TraductorPluginFactory::class,
			//Service\I18nService::class => Service\Factory\I18nServiceFactory::class,                    
        ],
    ],
	'controller_plugins' => [
		'factories' => [
            Controller\Plugin\TraductorPlugin::class => Controller\Plugin\TraductorPluginFactory::class,
            Controller\Plugin\IntlDateTimePlugin::class => InvokableFactory::class,
            Controller\Plugin\IntlNumberPlugin::class => InvokableFactory::class,
		],
		'aliases' => [
            'traductor' => Controller\Plugin\TraductorPlugin::class,
            'intlDateTime' => Controller\Plugin\IntlDateTimePlugin::class,
            'intlNumber' => Controller\Plugin\IntlNumberPlugin::class,
		],
	],
	'view_helpers' => [
		'factories' => [
			View\Helper\IcuTranslate::class => InvokableFactory::class,                    
        ],
       'aliases' => [
            'IcuTranslate' => View\Helper\IcuTranslate::class,
		],
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
