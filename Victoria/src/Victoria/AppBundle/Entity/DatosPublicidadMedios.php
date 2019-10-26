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


}
