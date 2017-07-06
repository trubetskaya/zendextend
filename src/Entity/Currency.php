<?php

namespace Lib\Entity {

    use Doctrine\ORM\Mapping as ORM;

    /**
     * Валюты
     * @ORM\Table(name="currencies")
     * @ORM\Entity
     */
    class Currency
    {
        use DocumentTrait;

        /**
         * @var string
         * @ORM\Column(name="iso_code", type="string", length=3, nullable=false, unique=true)
         */
        protected $isoCode;

        /**
         * @var string
         * @ORM\Column(name="html_code", type="string", length=10, nullable=false, unique=false)
         */
        protected $htmlCode;

        /**
         * @var string
         * @ORM\Column(name="rate", type="decimal", precision=20, scale=6, nullable=false, unique=false)
         */
        protected $rate = 1;

        /**
         * Locale
         * @var Locale
         * @ORM\OneToOne(targetEntity="Locale", mappedBy="currency")
         */
        protected $locale;

        /**
         * Get isoCode
         * @return string
         */
        public function getIsoCode()
        {
            return $this->isoCode;
        }

        /**
         * Set isoCode
         * @param string $isoCode
         * @return $this
         */
        public function setIsoCode($isoCode)
        {
            $this->isoCode = $isoCode;
            return $this;
        }

        /**
         * Get htmlCode
         * @return string
         */
        public function getHtmlCode()
        {
            return $this->htmlCode;
        }

        /**
         * Set htmlCode
         * @param string $htmlCode
         * @return $this
         */
        public function setHtmlCode($htmlCode)
        {
            $this->htmlCode = $htmlCode;
            return $this;
        }

        /**
         * Set rate
         * @return string
         */
        public function getRate()
        {
            return $this->rate;
        }

        /**
         * Set rate
         * @param string $rate
         * @return $this
         */
        public function setRate($rate)
        {
            $this->rate = $rate;
            return $this;
        }

        /**
         * Get locale
         * @return Locale
         */
        public function getLocale()
        {
            return $this->locale;
        }

        /**
         * Set locale
         * @param Locale $locale
         * @return $this
         */
        public function setLocale(Locale $locale)
        {
            $this->locale = $locale;
            return $this;
        }
    }
}
