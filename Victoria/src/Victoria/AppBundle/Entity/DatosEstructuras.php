<?php

namespace Victoria\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DatosEstructuras
 *
 * @ORM\Table(name="datos_estructuras")
 * @ORM\Entity
 */
class DatosEstructuras
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_estructura", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="datos_estructuras_id_estructura_seq", allocationSize=1, initialValue=1)
     */
    private $idEstructura;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=256, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_estructura", type="string", nullable=false)
     */
    private $tipoEstructura;



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
     * Set nombre
     *
     * @param string $nombre
     * @return DatosEstructuras
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
     * Set tipoEstructura
     *
     * @param string $tipoEstructura
     * @return DatosEstructuras
     */
    public function setTipoEstructura($tipoEstructura)
    {
        $this->tipoEstructura = $tipoEstructura;

        return $this;
    }

    /**
     * Get tipoEstructura
     *
     * @return string 
     */
    public function getTipoEstructura()
    {
        return $this->tipoEstructura;
    }
    
    function __toString()
    {
        return $this->nombre;
    }
}
