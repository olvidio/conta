<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comptes
 *
 * @ORM\Table(name="comptes")
 * @ORM\Entity
 */
class Comptes
{
    /**
     * @var integer
     *
     * @ORM\Column(name="codi", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="comptes_codi_seq", allocationSize=1, initialValue=1)
     */
    private $codi;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="text", nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="explicacio", type="text", nullable=true)
     */
    private $explicacio;

    /**
     * @var integer
     *
     * @ORM\Column(name="codi_alternatiu", type="integer", nullable=true)
     */
    private $codiAlternatiu;

    /**
     * @var integer
     *
     * @ORM\Column(name="tipus", type="integer", nullable=false)
     */
    private $tipus;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime", nullable=false)
     */
    private $dateCreated;


}

