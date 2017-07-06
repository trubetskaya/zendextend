<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 09.08.14
 * Time: 19:38
 */
namespace Lib\Entity {

    use Doctrine\ORM\Mapping as ORM;

    /**
     * Class Condition
     * @package Lib\Entity
     *
     * @ORM\Entity
     * @ORM\HasLifecycleCallbacks
     * @ORM\InheritanceType("JOINED")
     * @ORM\DiscriminatorColumn(name="entity_type", type="string")
     * @ORM\Table(name="conditions")
     */
    class Condition
    {
        use DocumentTrait;

        /** Conditions */
        const PENDING = 1;
        const APPROVED = 2;
        const REJECTED = 3;
    }
}