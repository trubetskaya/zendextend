<?php
/**
 * @link      http://github.com/zendframework/zend-validator for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Lib {

    /**
     * Class Module
     * @package Lib
     */
    class Module
    {
        /**
         * Get config
         * @return array
         */
        public function getConfig()
        {
            return include __DIR__ . '/../config/module.config.php';
        }
    }
}