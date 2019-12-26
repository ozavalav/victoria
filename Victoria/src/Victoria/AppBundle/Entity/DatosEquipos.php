<?php

namespace Victoria\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DatosEquipos
 *
 * @ORM\Table(name="datos_equipos", indexes={@ORM\Index(name="IDX_4882E375B8445919", columns={"id_campana"}), @ORM\Index(name="IDX_4882E375CE25AE0A", columns={"id_categoria"})})
 * @ORM\Entity
 */
class DatosEquipos
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_equipo", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="datos_equipos_id_equipo_seq", allocationSize=1, initialValue=1)
     */
    private $idEquipo;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=64, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="marca", type="string", length=64, nullable=true)
     */
    private $marca;

    /**
     * @var string
     *
     * @ORM\Column(name="modelo", type="string", length=64, nullable=true)
     */
    private $modelo;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_serie", type="string", length=64, nullable=true)
     */
    private $numeroSerie;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=128, nullable=true)
     */
    private $descripcion;

    /**
     * @var integer
     *
     * @ORM\Column(name="cantidad", type="integer", nullable=false)
     */
    private $cantidad;

    /**
     * @var string
     *
     * @ORM\Column(name="responsable", type="string", length=128, nullable=true)
     */
    private $responsable;

    /**
     * @var string
     *
     * @ORM\Column(name="ubicacion", type="string", length=128, nullable=true)
     */
    private $ubicacion;

    /**
     * @var integer
     *
     * @ORM\Column(name="estado", type="integer", nullable=false)
     */
    private $estado;

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
     * @var \AdCategoriasEquipo
     *
     * @ORM\ManyToOne(targetEntity="AdCategoriasEquipo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_categoria", referencedColumnName="id_categoria")
     * })
     */
    private $idCategoria;



    /**
     * Get idEquipo
     *
     * @return integer 
     */
    public function getIdEquipo()
    {
        return $this->idEquipo;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return DatosEquipos
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
     * Set marca
     *
     * @param string $marca
     * @return DatosEquipos
     */
    public function setMarca($marca)
    {
        $this->marca = $marca;

        return $this;
    }

    /**
     * Get marca
     *
     * @return string 
     */
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * Set modelo
     *
     * @param string $modelo
     * @return DatosEquipos
     */
    public function setModelo($modelo)
    {
        $this->modelo = $modelo;

        return $this;
    }

    /**
     * Get modelo
     *
     * @return string 
     */
    public function getModelo()
    {
        return $this->modelo;
    }

    /**
     * Set numeroSerie
     *
     * @param string $numeroSerie
     * @return DatosEquipos
     */
    public function setNumeroSerie($numeroSerie)
    {
        $this->numeroSerie = $numeroSerie;

        return $this;
    }

    /**
     * Get numeroSerie
     *
     * @return string 
     */
    public function getNumeroSerie()
    {
        return $this->numeroSerie;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return DatosEquipos
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
     * Set cantidad
     *
     * @param integer $cantidad
     * @return DatosEquipos
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return integer 
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set responsable
     *
     * @param string $responsable
     * @return DatosEquipos
     */
    public function setResponsable($responsable)
    {
        $this->responsable = $responsable;

        return $this;
    }

    /**
     * Get responsable
     *
     * @return string 
     */
    public function getResponsable()
    {
        return $this->responsable;
    }

    /**
     * Set ubicacion
     *
     * @param string $ubicacion
     * @return DatosEquipos
     */
    public function setUbicacion($ubicacion)
    {
        $this->ubicacion = $ubicacion;

        return $this;
    }

    /**
     * Get ubicacion
     *
     * @return string 
     */
    public function getUbicacion()
    {
        return $this->ubicacion;
    }

    /**
     * Set estado
     *
     * @param integer $estado
     * @return DatosEquipos
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
     * Set idCampana
     *
     * @param \Victoria\AppBundle\Entity\DatosCampanasPoliticas $idCampana
     * @return DatosEquipos
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
     * Set idCategoria
     *
     * @param \Victoria\AppBundle\Entity\AdCategoriasEquipo $idCategoria
     * @return DatosEquipos
     */
    public function setIdCategoria(\Victoria\AppBundle\Entity\AdCategoriasEquipo $idCategoria = null)
    {
        $this->idCategoria = $idCategoria;

        return $this;
    }

    /**
     * Get idCategoria
     *
     * @return \Victoria\AppBundle\Entity\AdCategoriasEquipo 
     */
    public function getIdCategoria()
    {
        return $this->idCategoria;
    }
}
