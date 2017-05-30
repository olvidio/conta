<?php

namespace Moviment\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Moviment
 *
 * @ORM\Table(name="moviments", indexes={@ORM\Index(name="codi_h_index", columns={"codi_h"}), @ORM\Index(name="data_index", columns={"data"}), @ORM\Index(name="codi_d_index", columns={"codi_d"})})
 * @ORM\Entity
 */
class Moviment
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="moviments_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data", type="datetime", precision=0, scale=0, nullable=false, unique=false)
     */
    private $data;

    /**
     * @var integer
     *
     * @ORM\Column(name="import", type="decimal", precision=8, scale=2, nullable=false, unique=false)
     */
    private $import;

    /**
     * @var string
     *
     * @ORM\Column(name="concepte", type="text", precision=0, scale=0, nullable=true, unique=false)
     */
    private $concepte;

    /**
     * @var string
     *
     * @ORM\Column(name="responsable", type="text", precision=0, scale=0, nullable=true, unique=false)
     */
    private $responsable;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime", precision=0, scale=0, nullable=false, unique=false)
     */
    private $dateCreated;

    /**
     * @var \Compte\Entity\Compte
     *
     * @ORM\ManyToOne(targetEntity="Compte\Entity\Compte",cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="codi_d", referencedColumnName="codi", nullable=true)
     * })
     */
    private $codiD;

    /**
     * @var \Compte\Entity\Compte
     *
     * @ORM\ManyToOne(targetEntity="Compte\Entity\Compte",cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="codi_h", referencedColumnName="codi", nullable=true)
     * })
     */
    private $codiH;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set data
     *
     * @param \DateTime $data
     *
     * @return Moviment
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return \DateTime
     */
    public function getData()
    {
		return $this->data;
    }

    /**
     * Set import
     *
     * @param integer $import
     *
     * @return Moviment
     */
    public function setImport($import)
    {
        $this->import = $import;

        return $this;
    }

    /**
     * Get import
     *
     * @return integer
     */
    public function getImport()
    {
        return $this->import;
    }

    /**
     * Set concepte
     *
     * @param string $concepte
     *
     * @return Moviment
     */
    public function setConcepte($concepte)
    {
        $this->concepte = $concepte;

        return $this;
    }

    /**
     * Get concepte
     *
     * @return string
     */
    public function getConcepte()
    {
        return $this->concepte;
    }

    /**
     * Set responsable
     *
     * @param string $responsable
     *
     * @return Moviment
     */
    public function setResponsable($responsable)
    {
        $this->responsable = $responsable;

        return $this;
    }

    /**
     * Get responsable
     *
     * @return string
     */
    public function getResponsable()
    {
        return $this->responsable;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return Moviment
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime
     */
    public function getDateCreated()
    {
		return $this->dateCreated;
    }

    /**
     * Set codiD
     *
     * @param \Compte\Entity\Compte $codiD
     *
     * @return Moviment
     */
    public function setCodiD(\Compte\Entity\Compte $codiD = null)
    {
        $this->codiD = $codiD;

        return $this;
    }

    /**
     * Get codiD
     *
     * @return \Compte\Entity\Compte
     */
    public function getCodiD()
    {
        return $this->codiD;
    }

    /**
     * Get value codiD
     *
     * @return \Compte\Entity\Compte
     */
    public function getValueCodiD()
    {
		//Torna l'ojecte: \Compte\Entity\Compte
        $objCompte = $this->codiD;
		return $objCompte->getCodi();
    }

    /**
     * Set codiH
     *
     * @param \Compte\Entity\Compte $codiH
     *
     * @return Moviment
     */
    public function setCodiH(\Compte\Entity\Compte $codiH = null)
    {
        $this->codiH = $codiH;

        return $this;
    }

    /**
     * Get codiH
     *
     * @return \Compte\Entity\Compte
     */
    public function getCodiH()
    {
        return $this->codiH;
    }
    /**
     * Get value codiH
     *
     * @return \Compte\Entity\Compte
     */
    public function getValueCodiH()
    {
		//Torna l'ojecte: \Compte\Entity\Compte
        $objCompte = $this->codiH;
		return $objCompte->getCodi();
    }
}

