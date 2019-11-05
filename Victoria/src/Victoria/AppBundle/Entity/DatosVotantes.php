<?php

namespace Victoria\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DatosVotantes
 *
 * @ORM\Table(name="datos_votantes", indexes={@ORM\Index(name="IDX_B9FD588E76120795", columns={"id_cv"})})
 * @ORM\Entity
 */
class DatosVotantes
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_votante", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="datos_votantes_id_votante_seq", allocationSize=1, initialValue=1)
     */
    private $idVotante;

    /**
     * @var string
     *
     * @ORM\Column(name="nombres", type="string", length=256, nullable=false)
     */
    private $nombres;

    /**
     * @var string
     *
     * @ORM\Column(name="apellidos", type="string", length=256, nullable=true)
     */
    private $apellidos;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_identidad", type="string", length=13, nullable=false)
     */
    private $numeroIdentidad;

    /**
     * @var integer
     *
     * @ORM\Column(name="edad", type="integer", nullable=true)
     */
    private $edad = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="telefonos", type="string", length=60, nullable=false)
     */
    private $telefonos;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=256, nullable=true)
     */
    private $email;

    /**
     * @var \DatosCentrosVotacion
     *
     * @ORM\ManyToOne(targetEntity="DatosCentrosVotacion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_cv", referencedColumnName="id_cv")
     * })
     */
    private $idCv;



    /**
     * Get idVotante
     *
     * @return integer 
     */
    public function getIdVotante()
    {
        return $this->idVotante;
    }

    /**
     * Set nombres
     *
     * @param string $nombres
     * @return DatosVotantes
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
     * @return DatosVotantes
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
     * @return DatosVotantes
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
     * Set edad
     *
     * @param integer $edad
     * @return DatosVotantes
     */
    public function setEdad($edad)
    {
        $this->edad = $edad;

        return $this;
    }

    /**
     * Get edad
     *
     * @return integer 
     */
    public function getEdad()
    {
        return $this->edad;
    }

    /**
     * Set telefonos
     *
     * @param string $telefonos
     * @return DatosVotantes
     */
    public function setTelefonos($telefonos)
    {
        $this->telefonos = $telefonos;

        return $this;
    }

    /**
     * Get telefonos
     *
     * @return string 
     */
    public function getTelefonos()
    {
        return $this->telefonos;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return DatosVotantes
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
     * Set idCv
     *
     * @param \Victoria\AppBundle\Entity\DatosCentrosVotacion $idCv
     * @return DatosVotantes
     */
    public function setIdCv(\Victoria\AppBundle\Entity\DatosCentrosVotacion $idCv = null)
    {
        $this->idCv = $idCv;

        return $this;
    }

    /**
     * Get idCv
     *
     * @return \Victoria\AppBundle\Entity\DatosCentrosVotacion 
     */
    public function getIdCv()
    {
        return $this->idCv;
    }
}
