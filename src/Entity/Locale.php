<?php
namespace Lib\Entity {

    use Zend\Form\Annotation as Form;
    use Doctrine\ORM\Mapping as ORM;

    /**
     * Языковые стандарты
     * @ORM\Table(name="locales")
     * @ORM\Entity(repositoryClass="Lib\Repository\LocaleRepository")
     */
    class Locale
    {
        use DocumentTrait;

        /**
         * @var string
         * @ORM\Column(name="iso", type="string", length=5, precision=0, scale=0, nullable=true, unique=true)
         */
        protected $iso;

        /**
         * @var string
         * @ORM\Column(name="iso_short", type="string", length=2, precision=0, scale=0, nullable=true, unique=true)
         */
        protected $isoShort;

        /**
         * @var Currency
         * @ORM\OneToOne(targetEntity="Currency", inversedBy="locale")
         * @ORM\JoinColumn(name="currency_id", referencedColumnName="id", nullable=false)
         * @Form\Exclude
         */
        protected $currency;

        /**
         * @var int
         * @ORM\Column(name="default", type="integer", precision=0, scale=0, nullable=false, unique=false)
         */
        protected $default = 0;

        /**
         * Set iso
         * @param string $iso
         * @return $this
         */
        public function setIso($iso)
        {
            $this->iso = $iso;
            return $this;
        }

        /**
         * Get iso
         * @return string
         */
        public function getIso()
        {
            return $this->iso;
        }

        /**
         * Get isoShort
         * @return string
         */
        public function getIsoShort()
        {
            return $this->isoShort;
        }

        /**
         * Set isoShort
         * @param string $isoShort
         * @return $this
         */
        public function setIsoShort($isoShort)
        {
            $this->isoShort = $isoShort;
            return $this;
        }

        /**
         * Get currency
         * @return Currency
         */
        public function getCurrency()
        {
            return $this->currency;
        }

        /**
         * Set currency
         * @param Currency $currency
         * @return $this
         */
        public function setCurrency(Currency $currency)
        {
            $this->currency = $currency;
            return $this;
        }

        /**
         * Set default
         * @param integer $default
         * @return $this
         */
        public function setDefault($default)
        {
            $this->default = $default;
            return $this;
        }

        /**
         * Get default
         * @return integer
         */
        public function getDefault()
        {
            return $this->default;
        }
    }
}