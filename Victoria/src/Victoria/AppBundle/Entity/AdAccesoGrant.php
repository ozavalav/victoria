<?php

namespace Victoria\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AdAccesoGrant
 *
 * @ORM\Table(name="ad_acceso_grant")
 * @ORM\Entity
 */
class AdAccesoGrant
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_acceso_grant", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="ad_acceso_grant_id_acceso_grant_seq", allocationSize=1, initialValue=1)
     */
    private $idAccesoGrant;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_acceso", type="integer", nullable=false)
     */
    private $idAcceso;

    /**
     * @var string
     *
     * @ORM\Column(name="objeto", type="string", length=8, nullable=false)
     */
    private $objeto;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_estado", type="integer", nullable=false)
     */
    private $idEstado;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_creacion", type="datetime", nullable=false)
     */
    private $fechaCreacion;

    /**
     * @var string
     *
     * @ORM\Column(name="usuario_creacion", type="string", length=32, nullable=false)
     */
    private $usuarioCreacion;

    /**
     * @var string
     *
     * @ORM\Column(name="usuario_ultima_modificacion", type="string", length=32, nullable=false)
     */
    private $usuarioUltimaModificacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_ultima_modificacion", type="datetime", nullable=false)
     */
    private $fechaUltimaModificacion;



    /**
     * Get idAccesoGrant
     *
     * @return integer
     */
    public function getIdAccesoGrant()
    {
        return $this->idAccesoGrant;
    }

    /**
     * Set idAcceso
     *
     * @param integer $idAcceso
     *
     * @return AdAccesoGrant
     */
    public function setIdAcceso($idAcceso)
    {
        $this->idAcceso = $idAcceso;

        return $this;
    }

    /**
     * Get idAcceso
     *
     * @return integer
     */
    public function getIdAcceso()
    {
        return $this->idAcceso;
    }

    /**
     * Set objeto
     *
     * @param string $objeto
     *
     * @return AdAccesoGrant
     */
    public function setObjeto($objeto)
    {
        $this->objeto = $objeto;

        return $this;
    }

    /**
     * Get objeto
     *
     * @return string
     */
    public function getObjeto()
    {
        return $this->objeto;
    }

    /**
     * Set idEstado
     *
     * @param integer $idEstado
     *
     * @return AdAccesoGrant
     */
    public function setIdEstado($idEstado)
    {
        $this->idEstado = $idEstado;

        return $this;
    }

    /**
     * Get idEstado
     *
     * @return integer
     */
    public function getIdEstado()
    {
        return $this->idEstado;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return AdAccesoGrant
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    /**
     * Get fechaCreacion
     *
     * @return \DateTime
     */
    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
    }

    /**
     * Set usuarioCreacion
     *
     * @param string $usuarioCreacion
     *
     * @return AdAccesoGrant
     */
    public function setUsuarioCreacion($usuarioCreacion)
    {
        $this->usuarioCreacion = $usuarioCreacion;

        return $this;
    }

    /**
     * Get usuarioCreacion
     *
     * @return string
     */
    public function getUsuarioCreacion()
    {
        return $this->usuarioCreacion;
    }

    /**
     * Set usuarioUltimaModificacion
     *
     * @param string $usuarioUltimaModificacion
     *
     * @return AdAccesoGrant
     */
    public function setUsuarioUltimaModificacion($usuarioUltimaModificacion)
    {
        $this->usuarioUltimaModificacion = $usuarioUltimaModificacion;

        return $this;
    }

    /**
     * Get usuarioUltimaModificacion
     *
     * @return string
     */
    public function getUsuarioUltimaModificacion()
    {
        return $this->usuarioUltimaModificacion;
    }

    /**
     * Set fechaUltimaModificacion
     *
     * @param \DateTime $fechaUltimaModificacion
     *
     * @return AdAccesoGrant
     */
    public function setFechaUltimaModificacion($fechaUltimaModificacion)
    {
        $this->fechaUltimaModificacion = $fechaUltimaModificacion;

        return $this;
    }

    /**
     * Get fechaUltimaModificacion
     *
     * @return \DateTime
     */
    public function getFechaUltimaModificacion()
    {
        return $this->fechaUltimaModificacion;
    }
}
