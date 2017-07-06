<?php
/**
 * Created by PhpStorm.
 * Date: 05.07.17
 * Time: 3:14
 */

namespace Lib\I18n\Translator\Loader {

    use Psr\Container\ContainerInterface;
    use Zend\I18n\Translator\Loader\RemoteLoaderInterface;
    use Zend\ServiceManager\ServiceManager;

    /**
     * Class Database
     */
    class Database implements RemoteLoaderInterface
    {
        /**
         * Service manger
         * @var ServiceManager
         */
        protected $serviceManger;

        /**
         * Database constructor.
         * @param ContainerInterface|ServiceManager $ci
         */
        public function __construct(ContainerInterface $ci)
        {
            $this->serviceManger = $ci;
        }

        /**
         * Function load
         * @param string $locale
         * @param string $textDomain
         * @return array
         */
        public function load($locale, $textDomain)
        {
            $messages['and'] = 'i';
            return $messages;
        }
    }
}