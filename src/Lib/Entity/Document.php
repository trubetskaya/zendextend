<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 03.07.14
 * Time: 23:00
 */

namespace Lib\Entity {

    use Doctrine\ORM\Mapping as ORM;
    use Zend\Form\Annotation as Form;
    use Doctrine\Common\Collections\ArrayCollection;

    /**
     * Class Document
     * @package Lib
     *
     * @ORM\Table(name="documents")
     * @ORM\Entity(repositoryClass="Lib\Repository\DocumentRepository")
     * @ORM\DiscriminatorColumn(name="doctype")
     * @ORM\InheritanceType("JOINED")
     * @ORM\HasLifecycleCallbacks
     */
    class Document implements
        DocumentInterface
    {
        use MetaTagsTrait, DocumentTrait;

        /**
         * @var Condition
         * @Form\Type("\DoctrineORMModule\Form\Element\EntitySelect")
         * @Form\Flags({"priority": 5})
         * @Form\Options({
         *      "label"         : "Condition",
         *      "target_class"  : Lib\Entity\Condition::class,
         *      "property"      : "name",
         *      "allow_empty"   : false
         * })
         * @Form\Attributes({
         *      "data-parsley-required": "true",
         *      "data-parsley-required-message": "Condition required",
         *      "class": "form-control select2_single",
         *      "id": "entity-condition"
         * })
         *
         * @ORM\ManyToOne(targetEntity=Condition::class)
         * @ORM\JoinColumn(name="condition_id", referencedColumnName="id", nullable=false)
         */
        protected $condition;

        /**
         * @var File[]
         * @Form\Exclude
         * @ORM\ManyToMany(targetEntity=File::class, cascade={"persist", "remove"}, inversedBy="documents")
         * @ORM\JoinTable(name="documents_files")
         * @ORM\OrderBy({"index" = "ASC"})
         */
        protected $files;

        /**
         * @var ArrayCollection
         * @Form\Type("\DoctrineORMModule\Form\Element\EntitySelect")
         * @Form\Flags({"priority": 50})
         * @Form\Options({
         *      "label"         : "Taxonomy",
         *      "target_class"  : "Lib\Entity\Taxonomy",
         *      "property"      : "name",
         *      "is_method"     : true,
         *      "find_method"   : {
         *          "name"      : "findBy",
         *          "params"    : {
         *              "criteria"  : { "active" : 1 },
         *              "orderBy"   : { "index" : "ASC" }
         *          }
         *      },
         *      "optgroup_identifier"   : "optGroupName",
         *      "allow_empty"           : false
         * })
         * @Form\Attributes({
         *      "data-parsley-required": "true",
         *      "data-parsley-required-message": "Category required",
         *      "class": "form-control select2_multiple",
         *      "id": "entity-taxonomy"
         * })
         *
         * @ORM\ManyToMany(targetEntity=Taxonomy::class, cascade={"persist"}, inversedBy="documents")
         * @ORM\JoinTable(name="documents_taxonomies")
         **/
        protected $taxonomy;

        /**
         * Constructor
         */
        public function __construct()
        {
            $this->files = new ArrayCollection;
            $this->taxonomy = new ArrayCollection;
        }

        /**
         * Set condition
         * @param Condition $condition
         * @return $this
         */
        public function setCondition(Condition $condition)
        {
            $this->condition = $condition;
            return $this;
        }

        /**
         * Get condition
         * @return Condition
         */
        public function getCondition()
        {
            return $this->condition;
        }

        /**
         * Add files
         * @param File $file
         * @return $this
         */
        public function addFiles(File $file)
        {
            $this->files->add($file);
            $file->addDocuments($this);

            return $this;
        }

        /**
         * Remove files
         * @param File $file
         * @return $this
         */
        public function removeFiles(File $file)
        {
            $this->files->removeElement($file);
            $file->removeDocuments($this);
            return $this;
        }

        /**
         * Get files
         * @return ArrayCollection
         */
        public function getFiles()
        {
            return $this->files;
        }

        /**
         * Add taxonomy
         * @param Taxonomy $taxonomy
         * @return $this
         */
        public function addTaxonomy(Taxonomy $taxonomy)
        {
            $this->taxonomy->add($taxonomy);
            $taxonomy->addDocuments($this);

            return $this;
        }

        /**
         * Remove taxonomy
         * @param Taxonomy $taxonomy
         * @return $this
         */
        public function removeTaxonomy(Taxonomy $taxonomy)
        {
            $this->taxonomy->removeElement($taxonomy);
            $taxonomy->removeDocuments($this);
            return $this;
        }

        /**
         * Get taxonomy
         * @return ArrayCollection
         */
        public function getTaxonomy()
        {
            return $this->taxonomy;
        }

        /**
         * Get preview
         * @return string
         */
        public function preview()
        {
            $preview = File::getDefaultPreview();
            if ($this->getFiles()->count()) {
                $preview = $this->getFiles()->first()
                    ->getPreview();
            }

            return $preview;
        }

        /**
         * Get taxonomy
         * @param int $depth
         * @param bool $only
         * @return string
         */
        public function taxonomy($depth = 2, $only = false)
        {
            $tree = [];
            $taxonomy = $this->getTaxonomy();
            if ($taxonomy->count()) {
                /** @var Taxonomy $term */
                $term = $taxonomy->first();
                while (!is_null($term) and --$depth >= 0) {
                    array_push($tree, $term->getName());
                    $term = $term->getRoot();
                    if ($only and ($depth == 0 or is_null($term))) {
                        return array_pop($tree);
                    }
                }
            }

            return implode(" ", array_reverse($tree));
        }
    }
}
