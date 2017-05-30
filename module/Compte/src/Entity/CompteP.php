<?php

namespace Compte\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comptes
 *
 * @ORM\Table(name="comptes_p")
 * @ORM\Entity
 */
class CompteP
{
	// tipus constants.
    const TIPUS_ACTIU       = 1; // Active.
    const TIPUS_PASSIU      = 2; // Passive.
	// status constants.
    const STATUS_ACTIVE       = 1; // Active.
    const STATUS_RETIRED      = 2; // Retired.
	
    /**
     * @var integer
     *
     * @ORM\Column(name="codi", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     */
    private $codi;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=false)
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
     * Get codi
     *
     * @return integer
     */
    public function getCodi()
    {
        return $this->codi;
    }

    /**
     * Set codi
     *
     * @param integer $codi
     *
     * @return Comptes
     */
    public function setCodi($codi)
    {
        $this->codi = $codi;

        return $this;
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
     * @return Comptes
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
     * @return Comptes
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
     * @return Comptes
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
     * @return Comptes
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
     * Returns possible tipus as array.
     * @return array
     */
    public static function getTipusList() 
    {
        return [
            self::TIPUS_ACTIU => _("Actiu"),
            self::TIPUS_PASSIU => _("Passiu")
        ];
    }    
    
    /**
     * Returns compte tipus as string.
     * @return string
     */
    public function getTipusAsString()
    {
        $list = self::getTipusList();
        if (isset($list[$this->tipus]))
            return $list[$this->tipus];
        
        return 'Unknown';
    }    


    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Comptes
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
     * Returns possible statuses as array.
     * @return array
     */
    public static function getStatusList() 
    {
        return [
            self::STATUS_ACTIVE => _("Actiu"),
            self::STATUS_RETIRED => _("Retirat")
        ];
    }    
    
    /**
     * Returns compte status as string.
     * @return string
     */
    public function getStatusAsString()
    {
        $list = self::getStatusList();
        if (isset($list[$this->status]))
            return $list[$this->status];
        
        return 'Unknown';
    }    

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return Comptes
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

