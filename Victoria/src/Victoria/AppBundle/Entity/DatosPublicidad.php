<?php

namespace Victoria\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DatosPublicidad
 *
 * @ORM\Table(name="datos_publicidad", indexes={@ORM\Index(name="IDX_C4D9A805B8445919", columns={"id_campana"}), @ORM\Index(name="IDX_C4D9A805EEFCF568", columns={"id_distrito"}), @ORM\Index(name="IDX_C4D9A8052E099FD6", columns={"tipo_publicidad"})})
 * @ORM\Entity
 */
class DatosPublicidad
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_publicidad", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="datos_publicidad_id_publicidad_seq", allocationSize=1, initialValue=1)
     */
    private $idPublicidad;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=256, nullable=true)
     */
    private $descripcion;

    /**
     * @var integer
     *
     * @ORM\Column(name="preparado_por", type="integer", nullable=false)
     */
    private $preparadoPor;

    /**
     * @var integer
     *
     * @ORM\Column(name="aprobado_por", type="integer", nullable=true)
     */
    private $aprobadoPor;

    /**
     * @var integer
     *
     * @ORM\Column(name="estado", type="integer", nullable=true)
     */
    private $estado;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_medio_publicidad", type="string", length=100, nullable=true)
     */
    private $nombreMedioPublicidad;

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
     * @var string
     *
     * @ORM\Column(name="target", type="string", length=100, nullable=true)
     */
    private $target;

    /**
     * @var integer
     *
     * @ORM\Column(name="pauta_publicitaria", type="integer", nullable=true)
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
     * @var integer
     *
     * @ORM\Column(name="me_asombra", type="integer", nullable=true)
     */
    private $meAsombra;

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
     * @var \AdTiposPublicidad
     *
     * @ORM\ManyToOne(targetEntity="AdTiposPublicidad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipo_publicidad", referencedColumnName="id_publicidad")
     * })
     */
    private $tipoPublicidad;



    /**
     * Get idPublicidad
     *
     * @return integer 
     */
    public function getIdPublicidad()
    {
        return $this->idPublicidad;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return DatosPublicidad
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
     * Set preparadoPor
     *
     * @param integer $preparadoPor
     * @return DatosPublicidad
     */
    public function setPreparadoPor($preparadoPor)
    {
        $this->preparadoPor = $preparadoPor;

        return $this;
    }

    /**
     * Get preparadoPor
     *
     * @return integer 
     */
    public function getPreparadoPor()
    {
        return $this->preparadoPor;
    }

    /**
     * Set aprobadoPor
     *
     * @param integer $aprobadoPor
     * @return DatosPublicidad
     */
    public function setAprobadoPor($aprobadoPor)
    {
        $this->aprobadoPor = $aprobadoPor;

        return $this;
    }

    /**
     * Get aprobadoPor
     *
     * @return integer 
     */
    public function getAprobadoPor()
    {
        return $this->aprobadoPor;
    }

    /**
     * Set estado
     *
     * @param integer $estado
     * @return DatosPublicidad
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
     * Set nombreMedioPublicidad
     *
     * @param string $nombreMedioPublicidad
     * @return DatosPublicidad
     */
    public function setNombreMedioPublicidad($nombreMedioPublicidad)
    {
        $this->nombreMedioPublicidad = $nombreMedioPublicidad;

        return $this;
    }

    /**
     * Get nombreMedioPublicidad
     *
     * @return string 
     */
    public function getNombreMedioPublicidad()
    {
        return $this->nombreMedioPublicidad;
    }

    /**
     * Set tipoAnuncio
     *
     * @param string $tipoAnuncio
     * @return DatosPublicidad
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
     * @return DatosPublicidad
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
     * Set target
     *
     * @param string $target
     * @return DatosPublicidad
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
     * @return DatosPublicidad
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
     * @return DatosPublicidad
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
     * @return DatosPublicidad
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
     * @return DatosPublicidad
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
     * @return DatosPublicidad
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
     * @return DatosPublicidad
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
     * @return DatosPublicidad
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
     * @return DatosPublicidad
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
     * @return DatosPublicidad
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
     * @return DatosPublicidad
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
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     * @return DatosPublicidad
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
     * @return DatosPublicidad
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
     * @return DatosPublicidad
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
     * @return DatosPublicidad
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
     * Set meAsombra
     *
     * @param integer $meAsombra
     * @return DatosPublicidad
     */
    public function setMeAsombra($meAsombra)
    {
        $this->meAsombra = $meAsombra;

        return $this;
    }

    /**
     * Get meAsombra
     *
     * @return integer 
     */
    public function getMeAsombra()
    {
        return $this->meAsombra;
    }

    /**
     * Set idCampana
     *
     * @param \Victoria\AppBundle\Entity\DatosCampanasPoliticas $idCampana
     * @return DatosPublicidad
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
     * @return DatosPublicidad
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

    /**
     * Set tipoPublicidad
     *
     * @param \Victoria\AppBundle\Entity\AdTiposPublicidad $tipoPublicidad
     * @return DatosPublicidad
     */
    public function setTipoPublicidad(\Victoria\AppBundle\Entity\AdTiposPublicidad $tipoPublicidad = null)
    {
        $this->tipoPublicidad = $tipoPublicidad;

        return $this;
    }

    /**
     * Get tipoPublicidad
     *
     * @return \Victoria\AppBundle\Entity\AdTiposPublicidad 
     */
    public function getTipoPublicidad()
    {
        return $this->tipoPublicidad;
    }
}
