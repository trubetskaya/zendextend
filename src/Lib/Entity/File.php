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
     * @package Lib\Entity
     *
     * @ORM\Entity
     * @ORM\Table(name="files")
     * @ORM\HasLifecycleCallbacks
     */
    class File
    {
        use DocumentTrait;

        /** Document preview */
        const PREVIEW_MIMETYPE = "/img/cms/mime/%s.png";
        const PREVIEW_DEFAULT = "/img/uploads/no_image.png";

        /** Константы загрузчика */
        const DIR_NAME = "/storage";
        const FILE_LENGTH = 16;
        const DIR_DEPTH = 4;

        /**
         * @var string
         * @Form\Type("Hidden")
         * @ORM\Column(name="name", type="string", length=255, nullable=false, unique=false)
         */
        protected $name;

        /**
         * @var string
         * @Form\Type("Hidden")
         * @ORM\Column(name="description", type="text", nullable=true, unique=false)
         */
        protected $description;

        /**
         * @var string
         * @Form\Type("Hidden")
         * @ORM\Column(name="hash", type="string", length=32, nullable=false, unique=true)
         */
        protected $hash;

        /**
         * @var string
         * @Form\Type("Hidden")
         * @ORM\Column(name="mime", type="string", length=64, nullable=false)
         */
        protected $type;

        /**
         * @var integer
         * @Form\Type("Hidden")
         * @ORM\Column(name="size", type="integer", nullable=true)
         */
        protected $size;

        /**
         * @var bool
         * @Form\Type("Hidden")
         * @ORM\Column(name="active", type="boolean", nullable=true)
         */
        protected $active = true;

        /**
         * @var int
         * @Form\Type("Hidden")
         * @ORM\Column(name="list_index", type="integer", nullable=false)
         */
        protected $index;

        /**
         * @var Document[]
         * @ORM\ManyToMany(targetEntity=Lib\Entity\Document::class, mappedBy="files")
         */
        protected $documents;

        /**
         * Construct
         */
        public function __construct()
        {
            $this->documents = new ArrayCollection;
            $this->hash = md5(uniqid(microtime(true)));
            $this->index = 0;
        }

        /**
         * Pre remove event
         * @ORM\PreRemove
         * @return $this
         */
        public function onPreRemove()
        {
            $fileLocation = PUBLIC_PATH . $this->getRelativeLocation();
            if (file_exists($fileLocation)) {
                unlink($fileLocation);
            }

            return $this;
        }

        /**
         * Set hash
         * @param string $hash
         * @return File
         */
        public function setHash($hash)
        {
            $this->hash = $hash;
            return $this;
        }

        /**
         * Get hash
         * @return string
         */
        public function getHash()
        {
            return $this->hash;
        }

        /**
         * Get mimeType
         * @return mixed
         */
        public function getType()
        {
            return $this->type;
        }

        /**
         * Set mimeType
         * @param string $mimeType
         * @return $this
         */
        public function setType($mimeType)
        {
            $this->type = $mimeType;
            return $this;
        }

        /**
         * Get size
         * @return int
         */
        public function getSize()
        {
            return $this->size;
        }

        /**
         * Set size
         * @param int $size
         * @return $this
         */
        public function setSize($size)
        {
            $this->size = $size;
            return $this;
        }

        /**
         * Get index
         * @return int
         */
        public function getIndex()
        {
            return $this->index;
        }

        /**
         * Set index
         * @param int $index
         * @return $this
         */
        public function setIndex($index)
        {
            $this->index = $index;
            return $this;
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
         * Get documents
         * @return ArrayCollection
         */
        public function getDocuments()
        {
            return $this->documents;
        }

        /**
         * Build relative file location
         * @return string
         */
        public function getRelativeLocation()
        {
            $fileInfo = explode(".", $this->getName());
            $locationHash = md5($this->getHash() . $this->getSize());

            $extension = "file";
            if (count($fileInfo) > 1) {
                $extension = array_pop($fileInfo);
            }

            return implode(DS, [self::DIR_NAME,
                implode(DS, str_split(substr($locationHash, 0, self::FILE_LENGTH), self::DIR_DEPTH)),
                implode(".", [substr($locationHash, self::FILE_LENGTH), $extension])
            ]);
        }

        /**
         * Get real file location
         * @return string
         */
        public function getRealLocation()
        {
            return PUBLIC_PATH . $this->getRelativeLocation();
        }

        /**
         * Get file directory
         * @return string
         */
        public function getDirectory()
        {
            $realLocation = $this->getRealLocation();
            return implode(DS, array_slice(explode(DS, $realLocation), 0, -1));
        }

        /**
         * Get preview
         * @return string
         */
        public function getPreview()
        {
            $info = new \finfo(FILEINFO_MIME_TYPE);
            $mime = explode(DS, $info->file($this->getRealLocation()));
            if ("image" == array_shift($mime)) {
                return $this->getRelativeLocation();
            }

            $ext = implode("", array_slice(explode(".", $this->getName()), -1));
            $preview = sprintf(self::PREVIEW_MIMETYPE, $ext);
            if (file_exists(PUBLIC_PATH . $preview)) {
                return $preview;
            }

            $preview = sprintf(self::PREVIEW_MIMETYPE, array_shift($mime));
            if (file_exists(PUBLIC_PATH . $preview)) {
                return $preview;
            }

            return self::getDefaultPreview();
        }

        /**
         * Get default preview
         * @return string
         */
        public static function getDefaultPreview()
        {
            return sprintf(self::PREVIEW_DEFAULT, "plain");
        }
    }
}
