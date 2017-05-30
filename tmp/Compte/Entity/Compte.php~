<?php

namespace Compte\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Compte
 *
 * @ORM\Table(name="comptes")
 * @ORM\Entity
 */
class Compte
{
    /**
     * @var integer
     *
     * @ORM\Column(name="codi", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $codi;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="comptes_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="text", precision=0, scale=0, nullable=false, unique=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="explicacio", type="text", precision=0, scale=0, nullable=false, unique=false)
     */
    private $explicacio;

    /**
     * @var integer
     *
     * @ORM\Column(name="codi_alternatiu", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $codiAlternatiu;

    /**
     * @var integer
     *
     * @ORM\Column(name="tipus", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $tipus;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime", precision=0, scale=0, nullable=false, unique=false)
     */
    private $dateCreated;


    /**
     * Set codi
     *
     * @param integer $codi
     *
     * @return Compte
     */
    public function setCodi($codi)
    {
        $this->codi = $codi;

        return $this;
    }

    /**
     * Get codi
     *
     * @return integer
     */
    public function getCodi()
    {
        return $this->codi;
    }

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
     * Set nom
     *
     * @param string $nom
     *
     * @return Compte
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set explicacio
     *
     * @param string $explicacio
     *
     * @return Compte
     */
    public function setExplicacio($explicacio)
    {
        $this->explicacio = $explicacio;

        return $this;
    }

    /**
     * Get explicacio
     *
     * @return string
     */
    public function getExplicacio()
    {
        return $this->explicacio;
    }

    /**
     * Set codiAlternatiu
     *
     * @param integer $codiAlternatiu
     *
     * @return Compte
     */
    public function setCodiAlternatiu($codiAlternatiu)
    {
        $this->codiAlternatiu = $codiAlternatiu;

        return $this;
    }

    /**
     * Get codiAlternatiu
     *
     * @return integer
     */
    public function getCodiAlternatiu()
    {
        return $this->codiAlternatiu;
    }

    /**
     * Set tipus
     *
     * @param integer $tipus
     *
     * @return Compte
     */
    public function setTipus($tipus)
    {
        $this->tipus = $tipus;

        return $this;
    }

    /**
     * Get tipus
     *
     * @return integer
     */
    public function getTipus()
    {
        return $this->tipus;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Compte
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return Compte
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
}
