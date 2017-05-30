<?php

namespace Moviment\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Moviments
 *
 * @ORM\Table(name="moviments", indexes={@ORM\Index(name="codi_h_index", columns={"codi_h"}), @ORM\Index(name="data_index", columns={"data"}), @ORM\Index(name="codi_d_index", columns={"codi_d"})})
 * @ORM\Entity
 */
class Moviments
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="moviments_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data", type="datetime", nullable=false)
     */
    private $data;

    /**
     * @var integer
     *
     * @ORM\Column(name="import", type="integer", nullable=false)
     */
    private $import;

    /**
     * @var string
     *
     * @ORM\Column(name="concepte", type="text", nullable=true)
     */
    private $concepte;

    /**
     * @var string
     *
     * @ORM\Column(name="responsable", type="text", nullable=true)
     */
    private $responsable;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime", nullable=false)
     */
    private $dateCreated;

    /**
     * @var \Moviment\Entity\Comptes
     *
     * @ORM\ManyToOne(targetEntity="Moviment\Entity\Comptes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="codi_d", referencedColumnName="codi")
     * })
     */
    private $codiD;

    /**
     * @var \Moviment\Entity\Comptes
     *
     * @ORM\ManyToOne(targetEntity="Moviment\Entity\Comptes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="codi_h", referencedColumnName="codi")
     * })
     */
    private $codiH;


}

