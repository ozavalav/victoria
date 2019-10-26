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


}
