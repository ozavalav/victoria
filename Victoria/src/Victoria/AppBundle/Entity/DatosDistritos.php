<?php

namespace Victoria\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DatosDistritos
 *
 * @ORM\Table(name="datos_distritos", indexes={@ORM\Index(name="IDX_3FA23379B8445919", columns={"id_campana"})})
 * @ORM\Entity
 */
class DatosDistritos
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_distrito", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="datos_distritos_id_distrito_seq", allocationSize=1, initialValue=1)
     */
    private $idDistrito;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=256, nullable=false)
     */
    private $nombre;

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
     * Get idDistrito
     *
     * @return integer 
     */
    public function getIdDistrito()
    {
        return $this->idDistrito;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return DatosDistritos
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
     * Set idCampana
     *
     * @param \Victoria\AppBundle\Entity\DatosCampanasPoliticas $idCampana
     * @return DatosDistritos
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
    
    function __toString()
    {
        return $this->nombre;
    }  
}
