<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.03.14
 * Time: 2:15
 */

namespace Lib\Entity {

    use Doctrine\Common\Collections\Collection;

    /**
     * Class EntityToArrayTrait
     * @package Lib\Stdlib
     */
    trait EntityToArrayTrait
    {

        protected static $depth = 3;

        /**
         * Возвращает ассоциативный массив свойств и значений объекта
         * @param int $depth
         * @return array
         */
        public function toArray($depth = 3)
        {
            $copy = [];
            foreach (get_object_vars($this) as $var => $value) {
                switch (true) {
                    /** @var Collection $value */
                    case $value instanceof Collection:
                        $copy[$var] = $value->map(function ($e) use ($depth) {
                            if (method_exists($e, 'toArray') && $depth) {
                                return $e->toArray(--$depth);
                            }

                            if (method_exists($e, 'getId')) {
                                return $e->getId();
                            }

                            return get_class($e);
                        });
                        break;

                    case $value instanceof \DateTime:
                        $copy[$var] = $value->format("Y-m-d H:i:s");
                        break;
                    case is_object($value):
                        if (method_exists($value, 'getId')) {
                            $copy[$var] = $value->getId();
                            break;
                        }

                        if (method_exists($value, 'toArray') && $depth) {
                            $copy[$var] = $value->toArray(--$depth);
                            break;
                        }

                        $copy[$var] = get_class($value);
                        break;
                    default:
                        $copy[$var] = $value;
                        break;
                }
            }

            return $copy;
        }
    }
}