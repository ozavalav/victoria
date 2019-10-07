<?php

namespace Victoria\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AdEstadosPresupuesto
 *
 * @ORM\Table(name="ad_estados_presupuesto")
 * @ORM\Entity
 */
class AdEstadosPresupuesto
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_estado_presupuesto", type="smallint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="ad_estados_presupuesto_id_estado_presupuesto_seq", allocationSize=1, initialValue=1)
     */
    private $idEstadoPresupuesto;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=128, nullable=true)
     */
    private $descripcion;


    /**
     * Set idEstadoPresupuesto
     *
     * @param integer $idEstadoPresupuesto
     * @return AdEstadosPresupuesto
     */
    public function setIdEstadoPresupuesto($idEstadoPresupuesto)
    {
        $this->idEstadoPresupuesto = $idEstadoPresupuesto;

        return $this;
    }

    /**
     * Get idEstadoPresupuesto
     *
     * @return integer 
     */
    public function getIdEstadoPresupuesto()
    {
        return $this->idEstadoPresupuesto;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return AdEstadosPresupuesto
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
