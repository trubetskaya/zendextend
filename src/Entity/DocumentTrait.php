<?php
/**
 * Created by PhpStorm.
 * Date: 29.01.16
 * Time: 22:17
 */
namespace Lib\Entity {

    use Doctrine\ORM\Mapping as ORM;
    use Zend\Form\Annotation as Form;

    /**
     * Trait DocumentTrait
     * @package Lib\Entity
     */
    trait DocumentTrait
    {
        use SortableTrait,
            EntityToArrayTrait;

        /**
         * @ORM\Id
         * @ORM\GeneratedValue(strategy="IDENTITY")
         * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false)
         */
        protected $id;

        /**
         * @var string
         * @Form\Type("Text")
         * @Form\Flags({"priority": 100})
         * @Form\Filter({"name" : "StripTags"})
         * @Form\Filter({"name" : "StringTrim"})
         * @Form\Validator({"name":"StringLength", "options" : {"min" : 3, "max" : 255}})
         * @Form\Options({"label": "Name"})
         * @Form\Attributes({
         *      "data-parsley-required" : "true",
         *      "data-parsley-required-message" : "Name cant be empty",
         *      "data-parsley-length": "[3, 255]",
         *      "data-parsley-length-message" : "Name must be from 3 to 255 symbols",
         *      "class": "form-control",
         *      "id": "entity-name"
         * })
         *
         * @ORM\Column(name="name", type="string", length=255, nullable=false, unique=false)
         */
        protected $name;

        /**
         * @var string
         * @Form\Type("Textarea")
         * @Form\Flags({"priority": 90})
         * @Form\Filter({"name" : "StripTags"})
         * @Form\Filter({"name" : "StringTrim"})
         * @Form\Validator({"name":"StringLength", "options" : {"min" : 5}})
         * @Form\Options({"label": "description"})
         * @Form\Attributes({
         *      "data-parsley-required" : "true",
         *      "data-parsley-required-message" : "Description cant be empty",
         *      "data-parsley-minlength" : "5",
         *      "data-parsley-minlength-message" : "Description must be greater than 5 symbols",
         *      "class" : "form-control",
         *      "id": "entity-description"
         * })
         * @ORM\Column(name="description", type="text", nullable=true, unique=false)
         */
        protected $description;

        /**
         * @var bool
         * @Form\AllowEmpty
         * @Form\Type("Checkbox")
         * @Form\Flags({"priority": 1})
         * @Form\Attributes({"class": "js-switch", "id": "entity-active"})
         * @Form\Options({"label": "Active", "use_hidden_element": true})
         * @ORM\Column(name="active", type="boolean", nullable=true)
         */
        protected $active = true;

        /**
         * @var \DateTime
         * @ORM\Column(name="created", type="datetime", precision=0, scale=0, nullable=false, unique=false)
         * @Form\Exclude
         */
        protected $created;

        /**
         * @var \DateTime
         * @ORM\Column(name="updated", type="datetime", nullable=false, unique=false)
         * @Form\Exclude
         */
        protected $updated;

        /**
         * Pre persist event
         * @ORM\PrePersist
         * @return $this
         */
        public function onPrePersist()
        {
            $this->created = new \DateTime;
            $this->updated = new \DateTime;
            return $this;
        }

        /**
         * Pre update event
         * @ORM\PreUpdate
         * @return $this
         */
        public function onPreUpdate()
        {
            $this->updated = new \DateTime;
            return $this;
        }

        /**
         * Get id
         * @return integer
         */
        public function getId()
        {
            return $this->id;
        }

        /**
         * Get name
         * @return string
         */
        public function getName()
        {
            return $this->name;
        }

        /**
         * Set name
         * @param string $name
         * @return $this
         */
        public function setName($name)
        {
            $this->name = $name;
            return $this;
        }

        /**
         * Set description
         * @param string $description
         * @return $this
         */
        public function setDescription($description)
        {
            $this->description = $description;
            return $this;
        }

        /**
         * Get description
         * @return string
         */
        public function getDescription()
        {
            return $this->description;
        }

        /**
         * Set active
         * @param boolean $active
         * @return $this
         */
        public function setActive($active = true)
        {
            $this->active = $active;
            return $this;
        }

        /**
         * Get active
         * @return boolean
         */
        public function getActive()
        {
            return $this->active;
        }

        /**
         * Is role active
         * @return bool
         */
        public function isActive()
        {
            return $this->active === true;
        }

        /**
         * Get created
         * @return \DateTime
         */
        public function getCreated()
        {
            return $this->created;
        }

        /**
         * Set created
         * @param \DateTime $created
         * @return $this
         */
        public function setCreated(\DateTime $created)
        {
            $this->created = $created;
            return $this;
        }

        /**
         * Get updated
         * @return \DateTime
         */
        public function getUpdated()
        {
            return $this->updated;
        }

        /**
         * Set updated
         * @param \DateTime $updated
         * @return $this
         */
        public function setUpdated(\DateTime $updated)
        {
            $this->updated = $updated;
            return $this;
        }

        /**
         * Function jsonSerialize
         * @return array
         */
        public function jsonSerialize()
        {
            return [
                "DT_RowId" => "row-{$this->getId()}",
                'doc' => $this->toArray()
            ];
        }
    }
}