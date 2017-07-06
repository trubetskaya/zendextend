<?php
namespace Lib {

    use Zend\I18n\Translator;
    use Doctrine\ORM\Mapping\Driver;
    use Lib\I18n\Translator as I18n;

    return [

        'service_manager' => [
            'factories' => [
                Translator\LoaderPluginManager::class => Translator\LoaderPluginManagerFactory::class,
                Translator\TranslatorInterface::class => I18n\DatabaseTranslationFactory::class
            ],
        ],
        'doctrine' => [

            // Metadata Mapping driver configuration
            'driver' => [

                // Configuration for service `doctrine.driver.orm_default` service
                'ext_entity' => [
                    'class' => Driver\AnnotationDriver::class,
                    'paths' => __DIR__ . '/../src/Lib/Entity'
                ],

                // Configuration for service `doctrine.driver.orm_default` service
                'orm_default' => [

                    // Map of driver names to be used within this driver chain, indexed by entity namespace
                    'drivers' => [
                        'Lib\Entity'  => 'ext_entity'
                    ],
                ],
            ],
        ],

        'view_helpers' => [
            'invokables' => [
                'translate' => \Zend\I18n\View\Helper\Translate::class
            ],
        ],
    ];
}
