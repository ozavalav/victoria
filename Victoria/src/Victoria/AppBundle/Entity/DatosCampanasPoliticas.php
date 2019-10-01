<?php

namespace Victoria\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DatosCampanasPoliticas
 *
 * @ORM\Table(name="datos_campanas_politicas", indexes={@ORM\Index(name="IDX_F2A062228813C45D", columns={"id_partido_politico"})})
 * @ORM\Entity
 */
class DatosCampanasPoliticas
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_campana", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="datos_campanas_politicas_id_campana_seq", allocationSize=1, initialValue=1)
     */
    private $idCampana;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=256, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="candidato", type="string", length=256, nullable=false)
     */
    private $candidato;

    /**
     * @var \AdPartidosPoliticos
     *
     * @ORM\ManyToOne(targetEntity="AdPartidosPoliticos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_partido_politico", referencedColumnName="id_partido_politico")
     * })
     */
    private $idPartidoPolitico;



    /**
     * Get idCampana
     *
     * @return integer 
     */
    public function getIdCampana()
    {
        return $this->idCampana;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return DatosCampanasPoliticas
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set candidato
     *
     * @param string $candidato
     * @return DatosCampanasPoliticas
     */
    public function setCandidato($candidato)
    {
        $this->candidato = $candidato;

        return $this;
    }

    /**
     * Get candidato
     *
     * @return string 
     */
    public function getCandidato()
    {
        return $this->candidato;
    }

    /**
     * Set idPartidoPolitico
     *
     * @param \Victoria\AppBundle\Entity\AdPartidosPoliticos $idPartidoPolitico
     * @return DatosCampanasPoliticas
     */
    public function setIdPartidoPolitico(\Victoria\AppBundle\Entity\AdPartidosPoliticos $idPartidoPolitico = null)
    {
        $this->idPartidoPolitico = $idPartidoPolitico;

        return $this;
    }

    /**
     * Get idPartidoPolitico
     *
     * @return \Victoria\AppBundle\Entity\AdPartidosPoliticos 
     */
    public function getIdPartidoPolitico()
    {
        return $this->idPartidoPolitico;
    }
    
    function __toString()
    {
        return $this->nombre;
    }  
}
