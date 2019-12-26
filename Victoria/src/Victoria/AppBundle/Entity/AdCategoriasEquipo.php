<?php

namespace Victoria\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AdCategoriasEquipo
 *
 * @ORM\Table(name="ad_categorias_equipo")
 * @ORM\Entity
 */
class AdCategoriasEquipo
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_categoria", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="ad_categorias_equipo_id_categoria_seq", allocationSize=1, initialValue=1)
     */
    private $idCategoria;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=32, nullable=true)
     */
    private $nombre;



    /**
     * Get idCategoria
     *
     * @return integer 
     */
    public function getIdCategoria()
    {
        return $this->idCategoria;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return AdCategoriasEquipo
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
    
    function __toString()
    {
        return $this->nombre;
    }  
}
