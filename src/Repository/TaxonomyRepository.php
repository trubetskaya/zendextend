<?php
/**
 * Created by PhpStorm.
 * Project: MarketGid
 * Date: 29.08.15
 * Time: 11:21
 */
namespace Lib\Repository {

    /**
     * Class Taxonomy
     * @package Lib
     * @subpackage Repository
     */
    class TaxonomyRepository extends EntityRepository
    {
        /**
         * Function getTerms
         * @param array $criteria
         * @return array
         */
        public function getTerms(array $criteria)
        {
            list ($doctype, $level) = [
                $criteria['doctype'],
                $criteria['level']
            ];

            $em = $this->getEntityManager();
            $alias = sprintf("taxonomy_%d", --$level);

            $exp = $em->getExpressionBuilder();
            $qb = $em->createQueryBuilder()
                ->select("taxonomy_0.id")->from($doctype, 'd')
                ->join('d.taxonomy', $alias)
                ->distinct();

            while ($level > 0) {
                $qb->join("{$alias}.root", sprintf("taxonomy_%d", --$level));
                $alias = sprintf("taxonomy_%d", $level);
            }

            $query = $this->createQueryBuilder('i')->select('i')
                ->where($exp->in('i.id', $qb->getDQL()))
                ->orderBy($exp->asc('i.name'))
                ->getQuery();

            return $query->getResult();
        }
    }
}