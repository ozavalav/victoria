<?php

namespace Victoria\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AdGrant
 *
 * @ORM\Table(name="ad_grant")
 * @ORM\Entity
 */
class AdGrant
{
    /**
     * @var string
     *
     * @ORM\Column(name="objeto", type="string", length=8, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="ad_grant_objeto_seq", allocationSize=1, initialValue=1)
     */
    private $objeto;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=64, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="titulo", type="string", length=64, nullable=false)
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="objeto_padre", type="string", length=8, nullable=false)
     */
    private $objetoPadre;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_imagen", type="string", length=128, nullable=true)
     */
    private $nombreImagen;

    /**
     * @var integer
     *
     * @ORM\Column(name="orden", type="integer", nullable=false)
     */
    private $orden;

    /**
     * @var integer
     *
     * @ORM\Column(name="visible", type="integer", nullable=false)
     */
    private $visible;

    /**
     * @var integer
     *
     * @ORM\Column(name="tipo_objeto", type="integer", nullable=false)
     */
    private $tipoObjeto;

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
     * Get objeto
     *
     * @return string
     */
    public function getObjeto()
    {
        return $this->objeto;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return AdGrant
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
     * Set titulo
     *
     * @param string $titulo
     *
     * @return AdGrant
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set objetoPadre
     *
     * @param string $objetoPadre
     *
     * @return AdGrant
     */
    public function setObjetoPadre($objetoPadre)
    {
        $this->objetoPadre = $objetoPadre;

        return $this;
    }

    /**
     * Get objetoPadre
     *
     * @return string
     */
    public function getObjetoPadre()
    {
        return $this->objetoPadre;
    }

    /**
     * Set nombreImagen
     *
     * @param string $nombreImagen
     *
     * @return AdGrant
     */
    public function setNombreImagen($nombreImagen)
    {
        $this->nombreImagen = $nombreImagen;

        return $this;
    }

    /**
     * Get nombreImagen
     *
     * @return string
     */
    public function getNombreImagen()
    {
        return $this->nombreImagen;
    }

    /**
     * Set orden
     *
     * @param integer $orden
     *
     * @return AdGrant
     */
    public function setOrden($orden)
    {
        $this->orden = $orden;

        return $this;
    }

    /**
     * Get orden
     *
     * @return integer
     */
    public function getOrden()
    {
        return $this->orden;
    }

    /**
     * Set visible
     *
     * @param integer $visible
     *
     * @return AdGrant
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * Get visible
     *
     * @return integer
     */
    public function getVisible()
    {
        return $this->visible;
    }

    /**
     * Set tipoObjeto
     *
     * @param integer $tipoObjeto
     *
     * @return AdGrant
     */
    public function setTipoObjeto($tipoObjeto)
    {
        $this->tipoObjeto = $tipoObjeto;

        return $this;
    }

    /**
     * Get tipoObjeto
     *
     * @return integer
     */
    public function getTipoObjeto()
    {
        return $this->tipoObjeto;
    }

    /**
     * Set idEstado
     *
     * @param integer $idEstado
     *
     * @return AdGrant
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
     * @return AdGrant
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
     * @return AdGrant
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
     * @return AdGrant
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
}
