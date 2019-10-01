<?php

namespace Victoria\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AdTiposComision
 *
 * @ORM\Table(name="ad_tipos_comision")
 * @ORM\Entity
 */
class AdTiposComision
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_tipo_comision", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="ad_tipos_comision_id_tipo_comision_seq", allocationSize=1, initialValue=1)
     */
    private $idTipoComision;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=256, nullable=true)
     */
    private $descripcion;



    /**
     * Get idTipoComision
     *
     * @return integer 
     */
    public function getIdTipoComision()
    {
        return $this->idTipoComision;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return AdTiposComision
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
