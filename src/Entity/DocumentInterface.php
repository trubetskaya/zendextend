<?php
/**
 * Created by PhpStorm.
 * Date: 15.06.16
 * Time: 16:45
 */

namespace Lib\Entity {

    /**
     * Interface DocumentInterface
     * @package Lib\Entity
     */
    interface DocumentInterface
    {
        /**
         * Get id
         * @return integer
         */
        public function getId();

        /**
         * Get created
         * @return \DateTime
         */
        public function getCreated();

        /**
         * Set created
         * @param \DateTime $created
         * @return $this
         */
        public function setCreated(\DateTime $created);

        /**
         * Get updated
         * @return \DateTime
         */
        public function getUpdated();

        /**
         * Set updated
         * @param \DateTime $updated
         * @return $this
         */
        public function setUpdated(\DateTime $updated);
    }
}
