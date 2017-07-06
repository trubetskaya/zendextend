<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 03.07.14
 * Time: 23:00
 */
namespace Lib\Entity {

    use Lib\Stdlib\ArrayObjectTrait;
    use Doctrine\ORM\Mapping as ORM;
    use Zend\Form\Annotation as Form;

    /**
     * Class Vocabulary
     * @package Lib
     * @subpackage Entity
     *
     * @ORM\Entity
     * @ORM\Table(
     *  name="vocabulary",
     *  indexes={ @ORM\Index(columns={"locale"}) },
     *  uniqueConstraints={
     *      @ORM\UniqueConstraint(
     *          columns={ "locale", "term" }
     *      )
     *  }
     * )
     */
    class Vocabulary
    {
        use VocabularyTrait,
            EntityToArrayTrait;
    }
}