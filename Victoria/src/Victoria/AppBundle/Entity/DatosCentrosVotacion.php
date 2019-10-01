<?php

namespace Victoria\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DatosCentrosVotacion
 *
 * @ORM\Table(name="datos_centros_votacion", indexes={@ORM\Index(name="IDX_AEC4A7FDB8445919", columns={"id_campana"}), @ORM\Index(name="IDX_AEC4A7FDEEFCF568", columns={"id_distrito"})})
 * @ORM\Entity
 */
class DatosCentrosVotacion
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_cv", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="datos_centros_votacion_id_cv_seq", allocationSize=1, initialValue=1)
     */
    private $idCv;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=256, nullable=false)
     */
    private $nombre;

    /**
     * @var integer
     *
     * @ORM\Column(name="tipo_cv", type="integer", nullable=false)
     */
    private $tipoCv;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=512, nullable=false)
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_edificio", type="string", length=256, nullable=true)
     */
    private $nombreEdificio;

    /**
     * @var integer
     *
     * @ORM\Column(name="cargar_electoral", type="integer", nullable=true)
     */
    private $cargarElectoral;

    /**
     * @var integer
     *
     * @ORM\Column(name="numero_mesas", type="integer", nullable=true)
     */
    private $numeroMesas;

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
     * Get idCv
     *
     * @return integer 
     */
    public function getIdCv()
    {
        return $this->idCv;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return DatosCentrosVotacion
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
     * Set tipoCv
     *
     * @param integer $tipoCv
     * @return DatosCentrosVotacion
     */
    public function setTipoCv($tipoCv)
    {
        $this->tipoCv = $tipoCv;

        return $this;
    }

    /**
     * Get tipoCv
     *
     * @return integer 
     */
    public function getTipoCv()
    {
        return $this->tipoCv;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     * @return DatosCentrosVotacion
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string 
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set nombreEdificio
     *
     * @param string $nombreEdificio
     * @return DatosCentrosVotacion
     */
    public function setNombreEdificio($nombreEdificio)
    {
        $this->nombreEdificio = $nombreEdificio;

        return $this;
    }

    /**
     * Get nombreEdificio
     *
     * @return string 
     */
    public function getNombreEdificio()
    {
        return $this->nombreEdificio;
    }

    /**
     * Set cargarElectoral
     *
     * @param integer $cargarElectoral
     * @return DatosCentrosVotacion
     */
    public function setCargarElectoral($cargarElectoral)
    {
        $this->cargarElectoral = $cargarElectoral;

        return $this;
    }

    /**
     * Get cargarElectoral
     *
     * @return integer 
     */
    public function getCargarElectoral()
    {
        return $this->cargarElectoral;
    }

    /**
     * Set numeroMesas
     *
     * @param integer $numeroMesas
     * @return DatosCentrosVotacion
     */
    public function setNumeroMesas($numeroMesas)
    {
        $this->numeroMesas = $numeroMesas;

        return $this;
    }

    /**
     * Get numeroMesas
     *
     * @return integer 
     */
    public function getNumeroMesas()
    {
        return $this->numeroMesas;
    }

    /**
     * Set idCampana
     *
     * @param \Victoria\AppBundle\Entity\DatosCampanasPoliticas $idCampana
     * @return DatosCentrosVotacion
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
     * @return DatosCentrosVotacion
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
        return $this->nombre;
    }      
}
