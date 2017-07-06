<?php
/**
 * Created by PhpStorm.
 * Project: MarketGid
 * Date: 29.08.15
 * Time: 11:21
 */
namespace Lib\Entity {

    use Zend\Form\Annotation as Form;
    use Doctrine\ORM\Mapping as ORM;
    use Doctrine\Common\Collections\ArrayCollection;

    /**
     * Class Taxonomy
     * @package Lib\Entity
     *
     * @ORM\Table(name="taxonomies")
     * @ORM\Entity(repositoryClass="Lib\Repository\TaxonomyRepository")
     * @ORM\HasLifecycleCallbacks
     *
     * @Form\Attributes({
     *      "data-bv-feedbackicons-valid"       : "glyphicon glyphicon-ok",
     *      "data-bv-feedbackicons-invalid"     : "glyphicon glyphicon-remove",
     *      "data-bv-feedbackicons-validating"  : "halflings refresh"
     * })
     */
    class Taxonomy
    {
        use DocumentTrait;

        /**
         * @var ArrayCollection
         * @ORM\ManyToMany(targetEntity=Document::class, mappedBy="taxonomy")
         * @Form\Exclude
         */
        protected $documents;

        /**
         * @var Taxonomy
         * @ORM\ManyToOne(targetEntity=Taxonomy::class, inversedBy="leafs")
         * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
         * @Form\Exclude
         */
        protected $root;

        /**
         * @var ArrayCollection
         * @ORM\OneToMany(targetEntity=Taxonomy::class, mappedBy="root")
         * @Form\Exclude
         */
        protected $leafs;

        /**
         * Constructor
         */
        public function __construct()
        {
            $this->documents = new ArrayCollection;
            $this->leafs = new ArrayCollection;
        }

        /**
         * Get root
         * @return Taxonomy
         */
        public function getRoot()
        {
            return $this->root;
        }

        /**
         * Set root
         * @param Taxonomy $root
         * @return $this
         */
        public function setRoot(Taxonomy $root)
        {
            $this->root = $root;
            return $this;
        }

        /**
         * Add leafs
         * @param Taxonomy $node
         * @return $this
         */
        public function addLeafs(Taxonomy $node)
        {
            $this->leafs->add($node);
            return $this;
        }

        /**
         * Remove leafs
         * @param Taxonomy $node
         * @return $this
         */
        public function removeLeafs(Taxonomy $node)
        {
            $this->leafs->removeElement($node);
            return $this;
        }

        /**
         * Get leafs
         * @return ArrayCollection
         */
        public function getLeafs()
        {
            return $this->leafs;
        }

        /**
         * Get document
         * @return Document[]|ArrayCollection
         */
        public function getDocuments()
        {
            return $this->documents;
        }

        /**
         * Add document
         * @param Document $document
         * @return $this
         */
        public function addDocuments(Document $document)
        {
            $this->documents->add($document);
            return $this;
        }

        /**
         * Remove document
         * @param Document $document
         * @return $this
         */
        public function removeDocuments(Document $document)
        {
            $this->documents->removeElement($document);
            return $this;
        }

        /**
         * Get optgroup name
         * @return string|Taxonomy
         */
        public function getOptGroupName()
        {
            if ($this->root instanceof Taxonomy) {
                return $this->getRoot()
                    ->getName();
            }

            return $this->root;
        }
    }
}