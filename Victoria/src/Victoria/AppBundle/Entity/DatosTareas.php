<?php

namespace Victoria\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DatosTareas
 *
 * @ORM\Table(name="datos_tareas", indexes={@ORM\Index(name="IDX_44C0B6CC6A540E", columns={"id_estado"}), @ORM\Index(name="IDX_44C0B6CCB5BE14FF", columns={"id_eventos"}), @ORM\Index(name="IDX_44C0B6CC4A40C0F0", columns={"id_responsable"})})
 * @ORM\Entity
 */
class DatosTareas
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_tarea", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="datos_tareas_id_tarea_seq", allocationSize=1, initialValue=1)
     */
    private $idTarea;

    /**
     * @var string
     *
     * @ORM\Column(name="titulo", type="string", length=50, nullable=true)
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=256, nullable=true)
     */
    private $descripcion;

    /**
     * @var integer
     *
     * @ORM\Column(name="progreso", type="integer", nullable=false)
     */
    private $progreso = '0';

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
     * @var \AdTiposEstadosTareas
     *
     * @ORM\ManyToOne(targetEntity="AdTiposEstadosTareas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_estado", referencedColumnName="id_tipo_estado_tareas")
     * })
     */
    private $idEstado;

    /**
     * @var \DatosEventos
     *
     * @ORM\ManyToOne(targetEntity="DatosEventos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_eventos", referencedColumnName="id_eventos")
     * })
     */
    private $idEventos;

    /**
     * @var \AdUser
     *
     * @ORM\ManyToOne(targetEntity="AdUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_responsable", referencedColumnName="id")
     * })
     */
    private $idResponsable;



    /**
     * Get idTarea
     *
     * @return integer 
     */
    public function getIdTarea()
    {
        return $this->idTarea;
    }

    /**
     * Set titulo
     *
     * @param string $titulo
     * @return DatosTareas
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
     * Set descripcion
     *
     * @param string $descripcion
     * @return DatosTareas
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

    /**
     * Set progreso
     *
     * @param integer $progreso
     * @return DatosTareas
     */
    public function setProgreso($progreso)
    {
        $this->progreso = $progreso;

        return $this;
    }

    /**
     * Get progreso
     *
     * @return integer 
     */
    public function getProgreso()
    {
        return $this->progreso;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     * @return DatosTareas
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
     * @return DatosTareas
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
     * @return DatosTareas
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
     * @return DatosTareas
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

    /**
     * Set idEstado
     *
     * @param \Victoria\AppBundle\Entity\AdTiposEstadosTareas $idEstado
     * @return DatosTareas
     */
    public function setIdEstado(\Victoria\AppBundle\Entity\AdTiposEstadosTareas $idEstado = null)
    {
        $this->idEstado = $idEstado;

        return $this;
    }

    /**
     * Get idEstado
     *
     * @return \Victoria\AppBundle\Entity\AdTiposEstadosTareas 
     */
    public function getIdEstado()
    {
        return $this->idEstado;
    }

    /**
     * Set idEventos
     *
     * @param \Victoria\AppBundle\Entity\DatosEventos $idEventos
     * @return DatosTareas
     */
    public function setIdEventos(\Victoria\AppBundle\Entity\DatosEventos $idEventos = null)
    {
        $this->idEventos = $idEventos;

        return $this;
    }

    /**
     * Get idEventos
     *
     * @return \Victoria\AppBundle\Entity\DatosEventos 
     */
    public function getIdEventos()
    {
        return $this->idEventos;
    }

    /**
     * Set idResponsable
     *
     * @param \Victoria\AppBundle\Entity\AdUser $idResponsable
     * @return DatosTareas
     */
    public function setIdResponsable(\Victoria\AppBundle\Entity\AdUser $idResponsable = null)
    {
        $this->idResponsable = $idResponsable;

        return $this;
    }

    /**
     * Get idResponsable
     *
     * @return \Victoria\AppBundle\Entity\AdUser 
     */
    public function getIdResponsable()
    {
        return $this->idResponsable;
    }
}
