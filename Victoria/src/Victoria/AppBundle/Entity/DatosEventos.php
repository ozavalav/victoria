<?php

namespace Victoria\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DatosEventos
 *
 * @ORM\Table(name="datos_eventos", indexes={@ORM\Index(name="IDX_AFB9D42AB8445919", columns={"id_campana"}), @ORM\Index(name="IDX_AFB9D42AEEFCF568", columns={"id_distrito"})})
 * @ORM\Entity
 */
class DatosEventos
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_eventos", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="datos_eventos_id_eventos_seq", allocationSize=1, initialValue=1)
     */
    private $idEventos;

    /**
     * @var string
     *
     * @ORM\Column(name="titulo", type="string", length=256, nullable=false)
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=256, nullable=true)
     */
    private $descripcion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_inicio", type="datetime", nullable=false)
     */
    private $fechaInicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_final", type="datetime", nullable=false)
     */
    private $fechaFinal;

    /**
     * @var string
     *
     * @ORM\Column(name="usuario_creacion", type="string", length=32, nullable=true)
     */
    private $usuarioCreacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_creacion", type="datetime", nullable=true)
     */
    private $fechaCreacion;

    /**
     * @var string
     *
     * @ORM\Column(name="usuario_ultima_modificacion", type="string", length=32, nullable=true)
     */
    private $usuarioUltimaModificacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_ultima_modificacion", type="datetime", nullable=true)
     */
    private $fechaUltimaModificacion;

    /**
     * @var \DatosCampanasPoliticas
     *
     * @ORM\ManyToOne(targetEntity="DatosCampanasPoliticas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_campana", referencedColumnName="id_campana")
     * })
     */
    private $idCampana;

    /**
     * @var \DatosDistritos
     *
     * @ORM\ManyToOne(targetEntity="DatosDistritos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_distrito", referencedColumnName="id_distrito")
     * })
     */
    private $idDistrito;



    /**
     * Get idEventos
     *
     * @return integer 
     */
    public function getIdEventos()
    {
        return $this->idEventos;
    }

    /**
     * Set titulo
     *
     * @param string $titulo
     * @return DatosEventos
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
     * @return DatosEventos
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
     * Set fechaInicio
     *
     * @param \DateTime $fechaInicio
     * @return DatosEventos
     */
    public function setFechaInicio($fechaInicio)
    {
        $this->fechaInicio = $fechaInicio;

        return $this;
    }

    /**
     * Get fechaInicio
     *
     * @return \DateTime 
     */
    public function getFechaInicio()
    {
        return $this->fechaInicio;
    }

    /**
     * Set fechaFinal
     *
     * @param \DateTime $fechaFinal
     * @return DatosEventos
     */
    public function setFechaFinal($fechaFinal)
    {
        $this->fechaFinal = $fechaFinal;

        return $this;
    }

    /**
     * Get fechaFinal
     *
     * @return \DateTime 
     */
    public function getFechaFinal()
    {
        return $this->fechaFinal;
    }

    /**
     * Set usuarioCreacion
     *
     * @param string $usuarioCreacion
     * @return DatosEventos
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
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     * @return DatosEventos
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
     * Set usuarioUltimaModificacion
     *
     * @param string $usuarioUltimaModificacion
     * @return DatosEventos
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
     * @return DatosEventos
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
     * Set idCampana
     *
     * @param \Victoria\AppBundle\Entity\DatosCampanasPoliticas $idCampana
     * @return DatosEventos
     */
    public function setIdCampana(\Victoria\AppBundle\Entity\DatosCampanasPoliticas $idCampana = null)
    {
        $this->idCampana = $idCampana;

        return $this;
    }

    /**
     * Get idCampana
     *
     * @return \Victoria\AppBundle\Entity\DatosCampanasPoliticas 
     */
    public function getIdCampana()
    {
        return $this->idCampana;
    }

    /**
     * Set idDistrito
     *
     * @param \Victoria\AppBundle\Entity\DatosDistritos $idDistrito
     * @return DatosEventos
     */
    public function setIdDistrito(\Victoria\AppBundle\Entity\DatosDistritos $idDistrito = null)
    {
        $this->idDistrito = $idDistrito;

        return $this;
    }

    /**
     * Get idDistrito
     *
     * @return \Victoria\AppBundle\Entity\DatosDistritos 
     */
    public function getIdDistrito()
    {
        return $this->idDistrito;
    }
    
    function __toString()
    {
        return $this->titulo;
    } 
}
