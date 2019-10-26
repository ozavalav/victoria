<?php

namespace Victoria\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DatosPersonas
 *
 * @ORM\Table(name="datos_personas")
 * @ORM\Entity
 */
class DatosPersonas
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_persona", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="datos_personas_id_persona_seq", allocationSize=1, initialValue=1)
     */
    private $idPersona;

    /**
     * @var string
     *
     * @ORM\Column(name="nombres", type="string", length=256, nullable=false)
     */
    private $nombres;

    /**
     * @var string
     *
     * @ORM\Column(name="apellidos", type="string", length=256, nullable=false)
     */
    private $apellidos;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_identidad", type="string", length=13, nullable=false)
     */
    private $numeroIdentidad;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono_1", type="string", length=14, nullable=false)
     */
    private $telefono1;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono_2", type="string", length=14, nullable=true)
     */
    private $telefono2;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono_3", type="string", length=14, nullable=true)
     */
    private $telefono3;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=256, nullable=false)
     */
    private $email;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_estructura", type="integer", nullable=false)
     */
    private $idEstructura;

    
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
     * @var integer
     *
     * @ORM\Column(name="estado", type="integer", nullable=false)
     */
    private $estado;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_comision", type="integer", nullable=false)
     */
    private $idComision;

    /**
     * Get idPersona
     *
     * @return integer 
     */
    public function getIdPersona()
    {
        return $this->idPersona;
    }

    /**
     * Set nombres
     *
     * @param string $nombres
     * @return DatosPersonas
     */
    public function setNombres($nombres)
    {
        $this->nombres = $nombres;

        return $this;
    }

    /**
     * Get nombres
     *
     * @return string 
     */
    public function getNombres()
    {
        return $this->nombres;
    }

    /**
     * Set apellidos
     *
     * @param string $apellidos
     * @return DatosPersonas
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get apellidos
     *
     * @return string 
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Set numeroIdentidad
     *
     * @param string $numeroIdentidad
     * @return DatosPersonas
     */
    public function setNumeroIdentidad($numeroIdentidad)
    {
        $this->numeroIdentidad = $numeroIdentidad;

        return $this;
    }

    /**
     * Get numeroIdentidad
     *
     * @return string 
     */
    public function getNumeroIdentidad()
    {
        return $this->numeroIdentidad;
    }

    /**
     * Set telefono1
     *
     * @param string $telefono1
     * @return DatosPersonas
     */
    public function setTelefono1($telefono1)
    {
        $this->telefono1 = $telefono1;

        return $this;
    }

    /**
     * Get telefono1
     *
     * @return string 
     */
    public function getTelefono1()
    {
        return $this->telefono1;
    }

    /**
     * Set telefono2
     *
     * @param string $telefono2
     * @return DatosPersonas
     */
    public function setTelefono2($telefono2)
    {
        $this->telefono2 = $telefono2;

        return $this;
    }

    /**
     * Get telefono2
     *
     * @return string 
     */
    public function getTelefono2()
    {
        return $this->telefono2;
    }

    /**
     * Set telefono3
     *
     * @param string $telefono3
     * @return DatosPersonas
     */
    public function setTelefono3($telefono3)
    {
        $this->telefono3 = $telefono3;

        return $this;
    }

    /**
     * Get telefono3
     *
     * @return string 
     */
    public function getTelefono3()
    {
        return $this->telefono3;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return DatosPersonas
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
     * Set idEstructura
     *
     * @param integer $idEstructura
     * @return DatosPersonas
     */
    public function setIdEstructura($idEstructura)
    {
        $this->idEstructura = $idEstructura;

        return $this;
    }

    /**
     * Get idEstructura
     *
     * @return integer 
     */
    public function getIdEstructura()
    {
        return $this->idEstructura;
    }

    /**
     * Set idCampana
     *
     * @param integer $idCampana
     * @return DatosPersonas
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
    /**
     * Set idDistrito
     *
     * @param integer $idDistrito
     * @return DatosPersonas
     */
    public function setIdDistrito($idDistrito)
    {
        $this->idDistrito = $idDistrito;

        return $this;
    }

    /**
     * Get idDistrito
     *
     * @return integer 
     */
    public function getIdDistrito()
    {
        return $this->idDistrito;
    }

    /**
     * Set estado
     *
     * @param integer $estado
     * @return DatosPersonas
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
     * Set idComision
     *
     * @param integer $idComision
     * @return DatosPersonas
     */
    public function setIdComision($idComision)
    {
        $this->idComision = $idComision;

        return $this;
    }

    /**
     * Get idComision
     *
     * @return integer 
     */
    public function getIdComision()
    {
        return $this->idComision;
    }    
    
    function __toString()
    {
        return $this->nombres . " " . $this->apellidos;
    }    
}
