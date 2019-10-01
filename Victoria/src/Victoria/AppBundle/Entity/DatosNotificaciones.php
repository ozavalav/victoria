<?php

namespace Victoria\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DatosNotificaciones
 *
 * @ORM\Table(name="datos_notificaciones", indexes={@ORM\Index(name="IDX_5E0E2F9AFCF8192D", columns={"id_usuario"}), @ORM\Index(name="IDX_5E0E2F9AB8445919", columns={"id_campana"}), @ORM\Index(name="IDX_5E0E2F9AEEFCF568", columns={"id_distrito"})})
 * @ORM\Entity
 */
class DatosNotificaciones
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_notificacion", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="datos_notificaciones_id_notificacion_seq", allocationSize=1, initialValue=1)
     */
    private $idNotificacion;

    /**
     * @var string
     *
     * @ORM\Column(name="mensaje", type="string", length=1024, nullable=false)
     */
    private $mensaje;

    /**
     * @var integer
     *
     * @ORM\Column(name="estado", type="integer", nullable=false)
     */
    private $estado = '1';
    
    /**
     * @var integer
     *
     * @ORM\Column(name="numero_mensaje", type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="datos_notificaciones_numero_mensaje_seq", allocationSize=1, initialValue=1)
     */
    private $numeroMensaje;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_enviado", type="datetime", nullable=true)
     */
    private $fechaEnviado;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_recibido", type="datetime", nullable=true)
     */
    private $fechaRecibido;

    /**
     * @var \AdUser
     *
     * @ORM\ManyToOne(targetEntity="AdUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_usuario", referencedColumnName="id")
     * })
     */
    private $idUsuario;

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
     * Get idNotificacion
     *
     * @return integer 
     */
    public function getIdNotificacion()
    {
        return $this->idNotificacion;
    }

    /**
     * Set mensaje
     *
     * @param string $mensaje
     * @return DatosNotificaciones
     */
    public function setMensaje($mensaje)
    {
        $this->mensaje = $mensaje;

        return $this;
    }

    /**
     * Get mensaje
     *
     * @return string 
     */
    public function getMensaje()
    {
        return $this->mensaje;
    }
    
    /**
     * Set numeroMensaje
     *
     * @param integer $numeroMensaje
     * @return DatosNotificaciones
     */
    public function setNumeroMensaje($numeroMensaje)
    {
        $this->numeroMensaje = $numeroMensaje;

        return $this;
    }

    /**
     * Get numeroMensaje
     *
     * @return integer 
     */
    public function getNumeroMensaje()
    {
        return $this->numeroMensaje;
    }

    /**
     * Set estado
     *
     * @param integer $estado
     * @return DatosNotificaciones
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
     * Set fechaEnviado
     *
     * @param \DateTime $fechaEnviado
     * @return DatosNotificaciones
     */
    public function setFechaEnviado($fechaEnviado)
    {
        $this->fechaEnviado = $fechaEnviado;

        return $this;
    }

    /**
     * Get fechaEnviado
     *
     * @return \DateTime 
     */
    public function getFechaEnviado()
    {
        return $this->fechaEnviado;
    }

    /**
     * Set fechaRecibido
     *
     * @param \DateTime $fechaRecibido
     * @return DatosNotificaciones
     */
    public function setFechaRecibido($fechaRecibido)
    {
        $this->fechaRecibido = $fechaRecibido;

        return $this;
    }

    /**
     * Get fechaRecibido
     *
     * @return \DateTime 
     */
    public function getFechaRecibido()
    {
        return $this->fechaRecibido;
    }

    /**
     * Set idUsuario
     *
     * @param \Victoria\AppBundle\Entity\AdUser $idUsuario
     * @return DatosNotificaciones
     */
    public function setIdUsuario(\Victoria\AppBundle\Entity\AdUser $idUsuario = null)
    {
        $this->idUsuario = $idUsuario;

        return $this;
    }

    /**
     * Get idUsuario
     *
     * @return \Victoria\AppBundle\Entity\AdUser 
     */
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    /**
     * Set idCampana
     *
     * @param \Victoria\AppBundle\Entity\DatosCampanasPoliticas $idCampana
     * @return DatosNotificaciones
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
     * @return DatosNotificaciones
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
}
