<?php
namespace Lib\Entity {

    use Doctrine\ORM\Mapping as ORM;
    use Zend\Form\Annotation as Form;

    /**
     * VocabularyTrait
     */
    trait VocabularyTrait
    {
        /**
         * @ORM\Id
         * @ORM\GeneratedValue(strategy="IDENTITY")
         * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false)
         * @Form\Exclude
         */
        protected $id;

        /**
         * @var string
         * @Form\Exclude
         * @Form\Type("Hidden")
         * @Form\Filter({"name": "StringTrim"})
         * @Form\Validator({"name":"StringLength", "options" : {"min" : 3, "max" : 255}})
         * @Form\Options({"label": "Term"})
         * @Form\Attributes({
         *      "data-parsley-required" : "true",
         *      "data-parsley-required-message" : "Term cant be empty",
         *      "data-parsley-length" : "[3, 255]",
         *      "data-parsley-length-message" : "Term length must be between 3 and 255 symbols",
         *      "class" : "form-control",
         *      "id": "vocabulary-term"
         * })
         *
         * @ORM\Column(name="term", type="string", length=255, nullable=false)
         */
        protected $term;

        /**
         * @var Locale
         * @Form\Exclude
         * @Form\Type("Hidden")
         * @Form\Options({
         *      "label"         : "Locale",
         *      "target_class"  : Lib\Entity\Locale::class,
         *      "property"      : "name",
         *      "allow_empty"   : false,
         *      "is_method"     : true,
         *      "find_method"   : {
         *          "name"      : "findBy",
         *          "params"    : {
         *              "criteria"  : { "active" : 1 },
         *              "orderBy"   : { "index": "ASC" }
         *          }
         *      }
         * })
         * @Form\Attributes({
         *      "data-parsley-required": "true",
         *      "data-parsley-required-message": "Locale required",
         *      "class": "form-control",
         *      "id": "vocabulary-locale"
         * })
         * @ORM\ManyToOne(targetEntity=Locale::class)
         * @ORM\JoinColumn(name="locale", referencedColumnName="id", nullable=false)
         */
        protected $locale;

        /**
         * @var string
         * @Form\Type("Textarea")
         * @Form\Filter({"name" : "StringTrim"})
         * @Form\Validator({"name":"StringLength", "options" : {"min" : 0}})
         * @Form\Options({"label": "Translation"})
         * @Form\Attributes({
         *      "data-parsley-required" : "true",
         *      "data-parsley-required-message" : "Translation cant be empty",
         *      "id": "vocabulary-translation",
         *      "class" : "form-control"
         * })
         * @ORM\Column(name="translation", type="text", nullable=false)
         */
        protected $translation;

        /**
         * Get id
         * @return mixed
         */
        public function getId()
        {
            return $this->id;
        }

        /**
         * Get term
         * @return string
         */
        public function getTerm()
        {
            return $this->term;
        }

        /**
         * Set term
         * @param string $term
         * @return $this
         */
        public function setTerm($term)
        {
            $this->term = $term;
            return $this;
        }

        /**
         * Get translation
         * @return string
         */
        public function getTranslation()
        {
            return $this->translation;
        }

        /**
         * Set translation
         * @param string $translation
         * @return $this
         */
        public function setTranslation($translation)
        {
            $this->translation = $translation;
            return $this;
        }

        /**
         * Get location
         * @return Locale
         */
        public function getLocale()
        {
            return $this->locale;
        }

        /**
         * Set location
         * @param Locale $location
         * @return $this
         */
        public function setLocale(Locale $location)
        {
            $this->locale = $location;
            return $this;
        }
    }
}
