<?php
/**
 * Created by PhpStorm.
 * Date: 05.07.17
 * Time: 3:27
 */

namespace Lib\I18n\Translator {

    use Interop\Container\ContainerInterface;
    use Zend\I18n\Translator\LoaderPluginManager;
    use Zend\I18n\Translator\Translator;
    use Zend\ServiceManager\Factory\FactoryInterface;
    use Lib\I18n\Translator\Loader\Database;

    /**
     * Class DatabaseTranslationFactory
     * @package Lib\I18n\Translator
     */
    class DatabaseTranslationFactory implements FactoryInterface
    {
        /**
         * Function __invoke
         * @param ContainerInterface $container
         * @param string $requestedName
         * @param array|null $options
         * @return Translator
         */
        public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
        {
            $pm = $container->get(LoaderPluginManager::class);
            $pm->setFactory(Database::class, function (ContainerInterface $ci) {
                return new Database($ci);
            });

            $instance = new Translator;
            $instance->setFallbackLocale('en_US');
            $instance->addRemoteTranslations(Database::class);
            $instance->setPluginManager($container->get(LoaderPluginManager::class));

            return $instance;
        }
    }
}
