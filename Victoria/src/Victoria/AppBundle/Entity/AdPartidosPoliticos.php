<?php

namespace Victoria\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AdPartidosPoliticos
 *
 * @ORM\Table(name="ad_partidos_politicos")
 * @ORM\Entity
 */
class AdPartidosPoliticos
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_partido_politico", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="ad_partidos_politicos_id_partido_politico_seq", allocationSize=1, initialValue=1)
     */
    private $idPartidoPolitico;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=256, nullable=true)
     */
    private $descripcion;



    /**
     * Get idPartidoPolitico
     *
     * @return integer 
     */
    public function getIdPartidoPolitico()
    {
        return $this->idPartidoPolitico;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return AdPartidosPoliticos
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }
    
    function __toString()
    {
        return $this->descripcion;
    }
}
