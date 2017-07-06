<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 28.08.14
 * Time: 18:11
 */

namespace Lib\Service {

    use Zend\Form\Form;
    use Zend\Form\Fieldset;
    use Zend\Form\Element\Collection;
    use Zend\Mvc\MvcEvent;
    use Zend\Mvc\Controller\Plugin\Params;
    use Zend\ServiceManager\ServiceLocatorInterface;
    use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
    use DoctrineORMModule\Form\Annotation\AnnotationBuilder;

    /**
     * Class ServiceAbstract
     * @package Lib\Service
     */
    abstract class ServiceAbstract
    {

        /**
         * Service locator
         * @var ServiceLocatorInterface
         */
        protected $serviceLocator;

        /**
         * Set service locator
         * @param ServiceLocatorInterface $serviceLocator
         * @return $this
         */
        public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
        {
            $this->serviceLocator = $serviceLocator;
            return $this;
        }

        /**
         * Get service locator
         * @return \Zend\ServiceManager\ServiceManager|ServiceLocatorInterface
         */
        public function getServiceLocator()
        {
            return $this->serviceLocator;
        }

        /**
         * Get entityManager
         * @return \Lib\ORM\EntityManager
         */
        public function getEntityManager()
        {
            return $this->serviceLocator->get('doctrine.entitymanager.orm_default');
        }

        /**
         * Get AnnotationBuilder
         * @return AnnotationBuilder
         */
        public function getAnnotationBuilder()
        {
            return $this->serviceLocator->get('doctrine.formannotationbuilder.orm_default');
        }

        /**
         * Create form
         * @param $entity
         * @return Form
         */
        public function createForm($entity)
        {
            /** @var Form $form */
            $form = $this->getAnnotationBuilder()
                ->createForm($entity);

            $hydrator = new DoctrineObject($this->getEntityManager(), false);
            $form->setHydrator($hydrator);

            /** @var Fieldset|Collection $fieldset */
            foreach ($form->getFieldsets() as $fieldset) {
                $fieldset->setHydrator($hydrator);
            }

            $form->bind($entity);
            return $form;
        }

        /**
         * Get request
         * @return \Zend\Http\PhpEnvironment\Request
         */
        public function getRequest()
        {
            return $this->getServiceLocator()
                ->get('request');
        }

        /**
         * Get route match
         * @return \Zend\Mvc\Router\RouteMatch
         */
        public function getRouteMatch()
        {
            return $this->getServiceLocator()->get('router')
                ->match($this->getRequest());
        }

        /**
         * Translate
         *
         * @param string $languageKey
         * @return string
         */
        public function translate($languageKey)
        {
            return $this->getServiceLocator()->get('translator')
                ->translate($languageKey);
        }

        /**
         * Get identity
         * @return \Lib\Entity\Account
         * @throws \Exception
         */
        public function identity()
        {
            $authService = $this->getServiceLocator()->get('doctrine.authenticationservice.orm_default');
            if (!$authService->hasIdentity()) {
                throw new \Exception(
                    '[LK_SERVICE_AUTHENTICATION_FAIL]'
                );
            }

            return $authService->getIdentity();
        }

        /**
         * Get mvc event
         * @return MvcEvent
         */
        public function getMvcEvent()
        {
            return $this->getServiceLocator()
                ->get('application')
                ->getMvcEvent();
        }

        /**
         * Function params
         * @return Params
         */
        public function params()
        {
            return $this->getServiceLocator()
                ->get('ControllerPluginManager')
                ->get('params');
        }
    }
}