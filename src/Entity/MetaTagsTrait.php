<?php
/**
 * Created by PhpStorm.
 * Date: 22.01.16
 * Time: 7:44
 */

namespace Lib\Entity {

    use Doctrine\ORM\Mapping as ORM;
    use Zend\Form\Annotation as Form;

    /**
     * Trait MetaTagsTrait
     * @package Lib\Entity
     */
    trait MetaTagsTrait
    {
        /**
         * @var string
         * @Form\Exclude
         * @Form\Type("Text")
         * @Form\Flags({"priority": 99})
         * @Form\Filter({"name" : "StripTags"})
         * @Form\Filter({"name" : "StringTrim"})
         * @Form\Validator({"name":"StringLength", "options" : {"min" : 3, "max" : 255}})
         * @Form\Options({"label": "Header name"})
         * @Form\Attributes({
         *      "data-parsley-required" : "true",
         *      "data-parsley-required-message" : "Header name cant be empty",
         *      "data-parsley-length" : "[3, 255]",
         *      "data-parsley-length-message" : "Header name must be from 3 to 255 symbols",
         *      "class" : "form-control",
         *      "id"    : "meta-name"
         * })
         *
         * @ORM\Column(name="meta_name", type="string", length=255, nullable=true, unique=false)
         */
        protected $metaName;

        /**
         * @var string
         * @Form\Exclude
         * @Form\Type("Textarea")
         * @Form\Flags({"priority": 89})
         * @Form\Filter({"name" : "StripTags"})
         * @Form\Filter({"name" : "StringTrim"})
         * @Form\Validator({"name":"StringLength", "options" : {"min" : 5}})
         * @Form\Options({"label": "Meta description"})
         * @Form\Attributes({
         *      "data-parsley-required" : "true",
         *      "data-parsley-required-message" : "Meta description cant be empty",
         *      "data-parsley-minlength" : "5",
         *      "data-parsley-minlength-message" : "Meta description must be greater than 5 symbols",
         *      "class" : "form-control"
         * })
         * @ORM\Column(name="meta_description", type="text", nullable=true, unique=false)
         */
        protected $metaDescription;

        /**
         * @var string
         * @Form\Exclude
         * @Form\Type("Textarea")
         * @Form\Flags({"priority": 88})
         * @Form\Filter({"name" : "StripTags"})
         * @Form\Filter({"name" : "StringTrim"})
         * @Form\Validator({"name":"StringLength", "options" : {"min" : 5}})
         * @Form\Options({"label": "Keywords", "class": "form-control", "id": "meta-keywords"})
         * @Form\Attributes({
         *      "data-parsley-required": "true",
         *      "data-parsley-required-message": "Keywords cant be empty",
         *      "data-parsley-minlength": "5",
         *      "data-parsley-minlength-message": "Keywords must be greater than 5 symbols",
         *      "id"    : "meta-keywords",
         *      "class" : "form-control",
         * })
         * @ORM\Column(name="meta_keywords", type="text", nullable=true, unique=false)
         */
        protected $metaKeywords;

        /**
         * Set metaName
         * @return string
         */
        public function getMetaName()
        {
            return $this->metaName;
        }

        /**
         * Set metaName
         * @param string $metaName
         * @return $this
         */
        public function setMetaName($metaName)
        {
            $this->metaName = $metaName;
            return $this;
        }

        /**
         * Set metaDescription
         * @return string
         */
        public function getMetaDescription()
        {
            return $this->metaDescription;
        }

        /**
         * Set metaDescription
         * @param string $metaDescription
         * @return $this
         */
        public function setMetaDescription($metaDescription)
        {
            $this->metaDescription = $metaDescription;
            return $this;
        }

        /**
         * Set metaKeywords
         * @return string
         */
        public function getMetaKeywords()
        {
            return $this->metaKeywords;
        }

        /**
         * Set metaKeywords
         * @param string $metaKeywords
         * @return $this
         */
        public function setMetaKeywords($metaKeywords)
        {
            $this->metaKeywords = $metaKeywords;
            return $this;
        }
    }
}