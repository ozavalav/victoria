<?php

namespace Victoria\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DatosPublicidadMedios
 *
 * @ORM\Table(name="datos_publicidad_medios", indexes={@ORM\Index(name="IDX_AFDFBDD1B8445919", columns={"id_campana"}), @ORM\Index(name="IDX_AFDFBDD11A051D29", columns={"id_publicidad"})})
 * @ORM\Entity
 */
class DatosPublicidadMedios
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_publicidad_medios", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="datos_publicidad_medios_id_publicidad_medios_seq", allocationSize=1, initialValue=1)
     */
    private $idPublicidadMedios;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_medio_publicitario", type="string", length=8, nullable=false)
     */
    private $nombreMedioPublicitario;

    /**
     * @var string
     *
     * @ORM\Column(name="audiencia", type="string", nullable=false)
     */
    private $audiencia;

    /**
     * @var string
     *
     * @ORM\Column(name="frecuencia", type="string", nullable=false)
     */
    private $frecuencia;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_anuncio", type="string", nullable=false)
     */
    private $tipoAnuncio;

    /**
     * @var string
     *
     * @ORM\Column(name="costo", type="string", nullable=false)
     */
    private $costo;

    /**
     * @var string
     *
     * @ORM\Column(name="comprobante_pago", type="string", nullable=false)
     */
    private $comprobantePago;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_estado", type="integer", nullable=true)
     */
    private $idEstado;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_creacion", type="datetime", nullable=true)
     */
    private $fechaCreacion;

    /**
     * @var string
     *
     * @ORM\Column(name="usuario_creacion", type="string", length=32, nullable=true)
     */
    private $usuarioCreacion;

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
     * @var \AdTiposPublicidad
     *
     * @ORM\ManyToOne(targetEntity="AdTiposPublicidad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_publicidad", referencedColumnName="id_publicidad")
     * })
     */
    private $idPublicidad;



    /**
     * Get idPublicidadMedios
     *
     * @return integer 
     */
    public function getIdPublicidadMedios()
    {
        return $this->idPublicidadMedios;
    }

    /**
     * Set nombreMedioPublicitario
     *
     * @param string $nombreMedioPublicitario
     * @return DatosPublicidadMedios
     */
    public function setNombreMedioPublicitario($nombreMedioPublicitario)
    {
        $this->nombreMedioPublicitario = $nombreMedioPublicitario;

        return $this;
    }

    /**
     * Get nombreMedioPublicitario
     *
     * @return string 
     */
    public function getNombreMedioPublicitario()
    {
        return $this->nombreMedioPublicitario;
    }

    /**
     * Set audiencia
     *
     * @param string $audiencia
     * @return DatosPublicidadMedios
     */
    public function setAudiencia($audiencia)
    {
        $this->audiencia = $audiencia;

        return $this;
    }

    /**
     * Get audiencia
     *
     * @return string 
     */
    public function getAudiencia()
    {
        return $this->audiencia;
    }

    /**
     * Set frecuencia
     *
     * @param string $frecuencia
     * @return DatosPublicidadMedios
     */
    public function setFrecuencia($frecuencia)
    {
        $this->frecuencia = $frecuencia;

        return $this;
    }

    /**
     * Get frecuencia
     *
     * @return string 
     */
    public function getFrecuencia()
    {
        return $this->frecuencia;
    }

    /**
     * Set tipoAnuncio
     *
     * @param string $tipoAnuncio
     * @return DatosPublicidadMedios
     */
    public function setTipoAnuncio($tipoAnuncio)
    {
        $this->tipoAnuncio = $tipoAnuncio;

        return $this;
    }

    /**
     * Get tipoAnuncio
     *
     * @return string 
     */
    public function getTipoAnuncio()
    {
        return $this->tipoAnuncio;
    }

    /**
     * Set costo
     *
     * @param string $costo
     * @return DatosPublicidadMedios
     */
    public function setCosto($costo)
    {
        $this->costo = $costo;

        return $this;
    }

    /**
     * Get costo
     *
     * @return string 
     */
    public function getCosto()
    {
        return $this->costo;
    }

    /**
     * Set comprobantePago
     *
     * @param string $comprobantePago
     * @return DatosPublicidadMedios
     */
    public function setComprobantePago($comprobantePago)
    {
        $this->comprobantePago = $comprobantePago;

        return $this;
    }

    /**
     * Get comprobantePago
     *
     * @return string 
     */
    public function getComprobantePago()
    {
        return $this->comprobantePago;
    }

    /**
     * Set idEstado
     *
     * @param integer $idEstado
     * @return DatosPublicidadMedios
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
     * @return DatosPublicidadMedios
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
     * @return DatosPublicidadMedios
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
     * @return DatosPublicidadMedios
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
     * @return DatosPublicidadMedios
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
     * @return DatosPublicidadMedios
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
     * Set idPublicidad
     *
     * @param \Victoria\AppBundle\Entity\AdTiposPublicidad $idPublicidad
     * @return DatosPublicidadMedios
     */
    public function setIdPublicidad(\Victoria\AppBundle\Entity\AdTiposPublicidad $idPublicidad = null)
    {
        $this->idPublicidad = $idPublicidad;

        return $this;
    }

    /**
     * Get idPublicidad
     *
     * @return \Victoria\AppBundle\Entity\AdTiposPublicidad 
     */
    public function getIdPublicidad()
    {
        return $this->idPublicidad;
    }
}
