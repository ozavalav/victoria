<?php

namespace Victoria\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AdTipoEgresos
 *
 * @ORM\Table(name="ad_tipo_egresos")
 * @ORM\Entity
 */
class AdTipoEgresos
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_tipo_egreso", type="smallint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="ad_tipo_egresos_id_tipo_egreso_seq", allocationSize=1, initialValue=1)
     */
    private $idTipoEgreso;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=128, nullable=true)
     */
    private $descripcion;



    /**
     * Get idTipoEgreso
     *
     * @return integer 
     */
    public function getIdTipoEgreso()
    {
        return $this->idTipoEgreso;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return AdTipoEgresos
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
