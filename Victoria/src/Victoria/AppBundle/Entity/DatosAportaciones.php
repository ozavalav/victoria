<?php

namespace Victoria\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * DatosAportaciones
 *
 * @ORM\Table(name="datos_aportaciones")
 * @ORM\Entity
 */
class DatosAportaciones
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_aportador", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="datos_aportaciones_id_aportador_seq", allocationSize=1, initialValue=1)
     */
    private $idAportador;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=256, nullable=true)
     */
    private $nombre;

    /**
     * @var integer
     *
     * @ORM\Column(name="tipo_aportador", type="integer", nullable=true)
     */
    private $tipoAportador;

    /**
     * @var integer
     *
     * @ORM\Column(name="tipo_aportacion", type="integer", nullable=true)
     */
    private $tipoAportacion;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=512, nullable=true)
     */
    private $descripcion;

    /**
     * @var integer
     *
     * @ORM\Column(name="valor_aportacion", type="integer", nullable=true)
     * @Assert\Regex(pattern="/\d+/", message="Ingrese solo numeros")
     */
    private $valorAportacion;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=60, nullable=true)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=128, nullable=true)
     * 
     * @Assert\Email(
     *     message = "El Email '{{ value }}' no es un email valido.",
     *     checkMX = true
     * )
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="compromiso", type="string", length=512, nullable=true)
     */
    private $compromiso;

    /**
     * @var integer
     *
     * @ORM\Column(name="aportador_actual", type="integer", nullable=true)
     */
    private $aportadorActual;

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
     * Get idAportador
     *
     * @return integer 
     */
    public function getIdAportador()
    {
        return $this->idAportador;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return DatosAportaciones
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
     * Set tipoAportador
     *
     * @param integer $tipoAportador
     * @return DatosAportaciones
     */
    public function setTipoAportador($tipoAportador)
    {
        $this->tipoAportador = $tipoAportador;

        return $this;
    }

    /**
     * Get tipoAportador
     *
     * @return integer 
     */
    public function getTipoAportador()
    {
        return $this->tipoAportador;
    }

    /**
     * Set tipoAportacion
     *
     * @param integer $tipoAportacion
     * @return DatosAportaciones
     */
    public function setTipoAportacion($tipoAportacion)
    {
        $this->tipoAportacion = $tipoAportacion;

        return $this;
    }

    /**
     * Get tipoAportacion
     *
     * @return integer 
     */
    public function getTipoAportacion()
    {
        return $this->tipoAportacion;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return DatosAportaciones
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
     * Set valorAportacion
     *
     * @param integer $valorAportacion
     * @return DatosAportaciones
     */
    public function setValorAportacion($valorAportacion)
    {
        $this->valorAportacion = $valorAportacion;

        return $this;
    }

    /**
     * Get valorAportacion
     *
     * @return integer 
     */
    public function getValorAportacion()
    {
        return $this->valorAportacion;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     * @return DatosAportaciones
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string 
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return DatosAportaciones
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set compromiso
     *
     * @param string $compromiso
     * @return DatosAportaciones
     */
    public function setCompromiso($compromiso)
    {
        $this->compromiso = $compromiso;

        return $this;
    }

    /**
     * Get compromiso
     *
     * @return string 
     */
    public function getCompromiso()
    {
        return $this->compromiso;
    }

    /**
     * Set aportadorActual
     *
     * @param integer $aportadorActual
     * @return DatosAportaciones
     */
    public function setAportadorActual($aportadorActual)
    {
        $this->aportadorActual = $aportadorActual;

        return $this;
    }

    /**
     * Get aportadorActual
     *
     * @return integer 
     */
    public function getAportadorActual()
    {
        return $this->aportadorActual;
    }
    
    /**
     * Set idCampana
     *
     * @param integer $idCampana
     * @return DatosAportaciones
     */
    public function setIdCampana($idCampana)
    {
        $this->idCampana = $idCampana;

        return $this;
    }

    /**
     * Get idCampana
     *
     * @return integer 
     */
    public function getIdCampana()
    {
        return $this->idCampana;
    }
}
