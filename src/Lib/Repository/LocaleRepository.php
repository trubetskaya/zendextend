<?php
/**
 * Created by PhpStorm.
 * Date: 03.01.16
 * Time: 4:49
 */

namespace Lib\Repository {

    use Lib\Entity\Locale;

    /**
     * Class LocaleRepository
     * @package Lib\Repository
     *
     * @method Locale findOneByDefault($default)
     */
    class LocaleRepository extends EntityRepository
    {
        /**
         * Finds all entities in the repository.
         * @return Locale[] The entities.
         */
        public function findAll()
        {
            return parent::findBy([], ['index' => 'ASC']);
        }
    }
}
