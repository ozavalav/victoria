<?php

namespace Victoria\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DatosComisionesCantidad
 *
 * @ORM\Table(name="datos_comisiones_cantidad")
 * @ORM\Entity
 */
class DatosComisionesCantidad
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_comision", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="datos_comisiones_cantidad_id_comision_seq", allocationSize=1, initialValue=1)
     */
    private $idComision;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_estructura", type="integer", nullable=true)
     */
    private $idEstructura;

    /**
     * @var integer
     *
     * @ORM\Column(name="tipo_estructura", type="integer", nullable=true)
     */
    private $tipoEstructura;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_tipo_comision", type="integer", nullable=true)
     */
    private $idTipoComision;

    /**
     * @var integer
     *
     * @ORM\Column(name="cantidad", type="integer", nullable=true)
     */
    private $cantidad;

    /**
     * Get idComision
     *
     * @return integer 
     */
    public function getIdComision()
    {
        return $this->idComision;
    }

    /**
     * Set idEstructura
     *
     * @param integer $idEstructura
     * @return DatosComisionesCantidad
     */
    public function setIdEstructura($idEstructura)
    {
        $this->idEstructura = $idEstructura;

        return $this;
    }

    /**
     * Get idEstructura
     *
     * @return integer 
     */
    public function getIdEstructura()
    {
        return $this->idEstructura;
    }

    /**
     * Set tipoEstructura
     *
     * @param integer $tipoEstructura
     * @return DatosComisionesCantidad
     */
    public function setTipoEstructura($tipoEstructura)
    {
        $this->tipoEstructura = $tipoEstructura;

        return $this;
    }

    /**
     * Get tipoEstructura
     *
     * @return integer 
     */
    public function getTipoEstructura()
    {
        return $this->tipoEstructura;
    }

    /**
     * Set idTipoComision
     *
     * @param integer $idTipoComision
     * @return DatosComisionesCantidad
     */
    public function setIdTipoComision($idTipoComision)
    {
        $this->idTipoComision = $idTipoComision;

        return $this;
    }

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
     * Set cantidad
     *
     * @param integer $cantidad
     * @return DatosComisionesCantidad
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return integer 
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }
}
