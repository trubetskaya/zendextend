<?php
/**
 * Created by PhpStorm.
 * Date: 05.07.17
 * Time: 3:14
 */

namespace Lib\I18n\Translator\Loader {

    use Doctrine\ORM\EntityManager;
    use Lib\Entity\Locale;
    use Lib\Entity\Vocabulary;
    use Psr\Container\ContainerInterface;
    use Zend\I18n\Translator\Loader\RemoteLoaderInterface;
    use Zend\Mvc\MvcEvent;
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
        protected $serviceLocator;

        /**
         * Database constructor.
         * @param ContainerInterface|ServiceManager $ci
         */
        public function __construct(ContainerInterface $ci)
        {
            $this->serviceLocator = $ci;
        }

        /**
         * Function load
         * @param string $iso
         * @param string $textDomain
         * @return array
         */
        public function load($iso, $textDomain = 'default')
        {
            /** @var EntityManager $em */
            $em = $this->serviceLocator->get('doctrine.entitymanager.orm_default');

            /** @var MvcEvent $e */
            $e = $this->serviceLocator->get('application')
                ->getMvcEvent();

            /** @var Locale $locale */
            $locale = $e->getParam('locale');
            if (!$locale instanceof Locale) {
                $locale = $em->getRepository(Locale::class)
                    ->findOneByDefault(1);
            }

            $e->setParam('locale', $locale);
            if (!$locale instanceof Locale) {
                throw new \InvalidArgumentException('Locale detection failure');
            }

            $exp = $em->getExpressionBuilder();
            $iterator = $em->getRepository(Vocabulary::class)->createQueryBuilder('v')
                ->select('v')->where($exp->eq('v.locale', ':locale'))
                ->setParameter('locale', $locale)->getQuery()
                ->iterate();

            $data = [];
            $iterator->rewind();
            while ($iterator->valid()) {
                /** @var Vocabulary $vok */
                $vok = array_shift($iterator->current());
                $data[$vok->getTerm()] = $vok->getTranslation();
                $iterator->next();
            }

            return $data;
        }
    }
}
