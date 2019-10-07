<?php

namespace Victoria\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DatosListaPresupuesto
 *
 * @ORM\Table(name="datos_lista_presupuesto", indexes={@ORM\Index(name="IDX_FB073B62371A524", columns={"id_presupuesto"})})
 * @ORM\Entity
 */
class DatosListaPresupuesto
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_lista", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="datos_lista_presupuesto_id_lista_seq", allocationSize=1, initialValue=1)
     */
    private $idLista;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=256, nullable=true)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="cantidad", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $cantidad;

    /**
     * @var string
     *
     * @ORM\Column(name="costo_unitario_estimado", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $costoUnitarioEstimado;

    /**
     * @var string
     *
     * @ORM\Column(name="costo_unitario_real", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $costoUnitarioReal;

    /**
     * @var \DatosPresupuestos
     *
     * @ORM\ManyToOne(targetEntity="DatosPresupuestos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_presupuesto", referencedColumnName="id_presupuesto")
     * })
     */
    private $idPresupuesto;



    /**
     * Get idLista
     *
     * @return integer 
     */
    public function getIdLista()
    {
        return $this->idLista;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return DatosListaPresupuesto
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
     * @param string $cantidad
     * @return DatosListaPresupuesto
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return string 
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set costoUnitarioEstimado
     *
     * @param string $costoUnitarioEstimado
     * @return DatosListaPresupuesto
     */
    public function setCostoUnitarioEstimado($costoUnitarioEstimado)
    {
        $this->costoUnitarioEstimado = $costoUnitarioEstimado;

        return $this;
    }

    /**
     * Get costoUnitarioEstimado
     *
     * @return string 
     */
    public function getCostoUnitarioEstimado()
    {
        return $this->costoUnitarioEstimado;
    }

    /**
     * Set costoUnitarioReal
     *
     * @param string $costoUnitarioReal
     * @return DatosListaPresupuesto
     */
    public function setCostoUnitarioReal($costoUnitarioReal)
    {
        $this->costoUnitarioReal = $costoUnitarioReal;

        return $this;
    }

    /**
     * Get costoUnitarioReal
     *
     * @return string 
     */
    public function getCostoUnitarioReal()
    {
        return $this->costoUnitarioReal;
    }

    /**
     * Set idPresupuesto
     *
     * @param \Victoria\AppBundle\Entity\DatosPresupuestos $idPresupuesto
     * @return DatosListaPresupuesto
     */
    public function setIdPresupuesto(\Victoria\AppBundle\Entity\DatosPresupuestos $idPresupuesto = null)
    {
        $this->idPresupuesto = $idPresupuesto;

        return $this;
    }

    /**
     * Get idPresupuesto
     *
     * @return \Victoria\AppBundle\Entity\DatosPresupuestos 
     */
    public function getIdPresupuesto()
    {
        return $this->idPresupuesto;
    }
}
