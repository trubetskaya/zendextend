<?php
/**
 * Created by PhpStorm.
 * Date: 01.02.16
 * Time: 19:55
 */

namespace Lib\Entity {

    use Doctrine\ORM\Mapping as ORM;
    use Zend\Form\Annotation as Form;

    /**
     * Trait SortableTrait
     * @package Lib\Entity
     */
    trait SortableTrait
    {
        /**
         * @var int
         * @ORM\Column(name="list_index", type="integer", nullable=false)
         * @Form\Exclude
         */
        protected $index;

        /**
         * Get index
         * @return int
         */
        public function getIndex()
        {
            return $this->index;
        }

        /**
         * Set index
         * @param int $index
         * @return $this
         */
        public function setIndex($index)
        {
            $this->index = $index;
            return $this;
        }
    }
}