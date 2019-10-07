<?php

namespace Victoria\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DatosPublicidadRedes
 *
 * @ORM\Table(name="datos_publicidad_redes", indexes={@ORM\Index(name="IDX_80C8FEECB8445919", columns={"id_campana"}), @ORM\Index(name="IDX_80C8FEEC1A051D29", columns={"id_publicidad"})})
 * @ORM\Entity
 */
class DatosPublicidadRedes
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_publicidad_redes", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="datos_publicidad_redes_id_publicidad_redes_seq", allocationSize=1, initialValue=1)
     */
    private $idPublicidadRedes;

    /**
     * @var string
     *
     * @ORM\Column(name="target", type="string", nullable=false)
     */
    private $target;

    /**
     * @var integer
     *
     * @ORM\Column(name="pauta_publicitaria", type="integer", nullable=false)
     */
    private $pautaPublicitaria;

    /**
     * @var integer
     *
     * @ORM\Column(name="personas_alcanzadas", type="integer", nullable=true)
     */
    private $personasAlcanzadas;

    /**
     * @var integer
     *
     * @ORM\Column(name="me_gusta", type="integer", nullable=true)
     */
    private $meGusta;

    /**
     * @var integer
     *
     * @ORM\Column(name="me_encanta", type="integer", nullable=true)
     */
    private $meEncanta;

    /**
     * @var integer
     *
     * @ORM\Column(name="me_divierte", type="integer", nullable=true)
     */
    private $meDivierte;

    /**
     * @var integer
     *
     * @ORM\Column(name="me_enoja", type="integer", nullable=true)
     */
    private $meEnoja;

    /**
     * @var integer
     *
     * @ORM\Column(name="me_entristece", type="integer", nullable=true)
     */
    private $meEntristece;

    /**
     * @var integer
     *
     * @ORM\Column(name="comentarios_positivos", type="integer", nullable=true)
     */
    private $comentariosPositivos;

    /**
     * @var integer
     *
     * @ORM\Column(name="comentarios_negativos", type="integer", nullable=true)
     */
    private $comentariosNegativos;

    /**
     * @var integer
     *
     * @ORM\Column(name="compartidos", type="integer", nullable=true)
     */
    private $compartidos;

    /**
     * @var string
     *
     * @ORM\Column(name="resumen_interaccion", type="string", length=100, nullable=true)
     */
    private $resumenInteraccion;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_medio_publicitario", type="string", length=100, nullable=true)
     */
    private $nombreMedioPublicitario;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_anuncio", type="string", length=100, nullable=true)
     */
    private $tipoAnuncio;

    /**
     * @var string
     *
     * @ORM\Column(name="comprobante_pago", type="string", length=100, nullable=true)
     */
    private $comprobantePago;

    /**
     * @var integer
     *
     * @ORM\Column(name="estado", type="integer", nullable=true)
     */
    private $estado;

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
     * Get idPublicidadRedes
     *
     * @return integer 
     */
    public function getIdPublicidadRedes()
    {
        return $this->idPublicidadRedes;
    }

    /**
     * Set target
     *
     * @param string $target
     * @return DatosPublicidadRedes
     */
    public function setTarget($target)
    {
        $this->target = $target;

        return $this;
    }

    /**
     * Get target
     *
     * @return string 
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Set pautaPublicitaria
     *
     * @param integer $pautaPublicitaria
     * @return DatosPublicidadRedes
     */
    public function setPautaPublicitaria($pautaPublicitaria)
    {
        $this->pautaPublicitaria = $pautaPublicitaria;

        return $this;
    }

    /**
     * Get pautaPublicitaria
     *
     * @return integer 
     */
    public function getPautaPublicitaria()
    {
        return $this->pautaPublicitaria;
    }

    /**
     * Set personasAlcanzadas
     *
     * @param integer $personasAlcanzadas
     * @return DatosPublicidadRedes
     */
    public function setPersonasAlcanzadas($personasAlcanzadas)
    {
        $this->personasAlcanzadas = $personasAlcanzadas;

        return $this;
    }

    /**
     * Get personasAlcanzadas
     *
     * @return integer 
     */
    public function getPersonasAlcanzadas()
    {
        return $this->personasAlcanzadas;
    }

    /**
     * Set meGusta
     *
     * @param integer $meGusta
     * @return DatosPublicidadRedes
     */
    public function setMeGusta($meGusta)
    {
        $this->meGusta = $meGusta;

        return $this;
    }

    /**
     * Get meGusta
     *
     * @return integer 
     */
    public function getMeGusta()
    {
        return $this->meGusta;
    }

    /**
     * Set meEncanta
     *
     * @param integer $meEncanta
     * @return DatosPublicidadRedes
     */
    public function setMeEncanta($meEncanta)
    {
        $this->meEncanta = $meEncanta;

        return $this;
    }

    /**
     * Get meEncanta
     *
     * @return integer 
     */
    public function getMeEncanta()
    {
        return $this->meEncanta;
    }

    /**
     * Set meDivierte
     *
     * @param integer $meDivierte
     * @return DatosPublicidadRedes
     */
    public function setMeDivierte($meDivierte)
    {
        $this->meDivierte = $meDivierte;

        return $this;
    }

    /**
     * Get meDivierte
     *
     * @return integer 
     */
    public function getMeDivierte()
    {
        return $this->meDivierte;
    }

    /**
     * Set meEnoja
     *
     * @param integer $meEnoja
     * @return DatosPublicidadRedes
     */
    public function setMeEnoja($meEnoja)
    {
        $this->meEnoja = $meEnoja;

        return $this;
    }

    /**
     * Get meEnoja
     *
     * @return integer 
     */
    public function getMeEnoja()
    {
        return $this->meEnoja;
    }

    /**
     * Set meEntristece
     *
     * @param integer $meEntristece
     * @return DatosPublicidadRedes
     */
    public function setMeEntristece($meEntristece)
    {
        $this->meEntristece = $meEntristece;

        return $this;
    }

    /**
     * Get meEntristece
     *
     * @return integer 
     */
    public function getMeEntristece()
    {
        return $this->meEntristece;
    }

    /**
     * Set comentariosPositivos
     *
     * @param integer $comentariosPositivos
     * @return DatosPublicidadRedes
     */
    public function setComentariosPositivos($comentariosPositivos)
    {
        $this->comentariosPositivos = $comentariosPositivos;

        return $this;
    }

    /**
     * Get comentariosPositivos
     *
     * @return integer 
     */
    public function getComentariosPositivos()
    {
        return $this->comentariosPositivos;
    }

    /**
     * Set comentariosNegativos
     *
     * @param integer $comentariosNegativos
     * @return DatosPublicidadRedes
     */
    public function setComentariosNegativos($comentariosNegativos)
    {
        $this->comentariosNegativos = $comentariosNegativos;

        return $this;
    }

    /**
     * Get comentariosNegativos
     *
     * @return integer 
     */
    public function getComentariosNegativos()
    {
        return $this->comentariosNegativos;
    }

    /**
     * Set compartidos
     *
     * @param integer $compartidos
     * @return DatosPublicidadRedes
     */
    public function setCompartidos($compartidos)
    {
        $this->compartidos = $compartidos;

        return $this;
    }

    /**
     * Get compartidos
     *
     * @return integer 
     */
    public function getCompartidos()
    {
        return $this->compartidos;
    }

    /**
     * Set resumenInteraccion
     *
     * @param string $resumenInteraccion
     * @return DatosPublicidadRedes
     */
    public function setResumenInteraccion($resumenInteraccion)
    {
        $this->resumenInteraccion = $resumenInteraccion;

        return $this;
    }

    /**
     * Get resumenInteraccion
     *
     * @return string 
     */
    public function getResumenInteraccion()
    {
        return $this->resumenInteraccion;
    }

    /**
     * Set nombreMedioPublicitario
     *
     * @param string $nombreMedioPublicitario
     * @return DatosPublicidadRedes
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
     * Set tipoAnuncio
     *
     * @param string $tipoAnuncio
     * @return DatosPublicidadRedes
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
     * Set comprobantePago
     *
     * @param string $comprobantePago
     * @return DatosPublicidadRedes
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
     * Set estado
     *
     * @param integer $estado
     * @return DatosPublicidadRedes
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return integer 
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     * @return DatosPublicidadRedes
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
     * @return DatosPublicidadRedes
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
     * @return DatosPublicidadRedes
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
     * @return DatosPublicidadRedes
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
     * @return DatosPublicidadRedes
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
     * @return DatosPublicidadRedes
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
