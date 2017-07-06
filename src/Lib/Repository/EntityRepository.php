<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.05.15
 * Time: 15:57
 */

namespace Lib\Repository {

    /**
     * Class EntityRepository
     * @package Lib\ORM
     */
    class EntityRepository extends \Doctrine\ORM\EntityRepository
    {
        /**
         * Creates a new QueryBuilder instance that is prepopulated for this entity name.
         * @param string $alias
         * @param null|string $indexBy
         * @return \Doctrine\ORM\QueryBuilder
         */
        public function createQueryBuilder($alias, $indexBy = null)
        {
            return $this->_em->createQueryBuilder()->select($alias)
                ->from($this->_entityName, $alias, $indexBy);
        }
    }
}
