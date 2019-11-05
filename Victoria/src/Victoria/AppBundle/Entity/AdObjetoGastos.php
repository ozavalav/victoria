<?php

namespace Victoria\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AdObjetoGastos
 *
 * @ORM\Table(name="ad_objeto_gastos")
 * @ORM\Entity
 */
class AdObjetoGastos
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_objeto_gasto", type="smallint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="ad_objeto_gastos_id_objeto_gasto_seq", allocationSize=1, initialValue=1)
     */
    private $idObjetoGasto;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=128, nullable=true)
     */
    private $descripcion;



    /**
     * Get idObjetoGasto
     *
     * @return integer 
     */
    public function getIdObjetoGasto()
    {
        return $this->idObjetoGasto;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return AdObjetoGastos
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
