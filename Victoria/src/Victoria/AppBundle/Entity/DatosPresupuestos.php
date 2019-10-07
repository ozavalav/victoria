<?php

namespace Victoria\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DatosPresupuestos
 *
 * @ORM\Table(name="datos_presupuestos", indexes={@ORM\Index(name="IDX_A534A80EB8445919", columns={"id_campana"}), @ORM\Index(name="IDX_A534A80EEEFCF568", columns={"id_distrito"})})
 * @ORM\Entity
 */
class DatosPresupuestos
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_presupuesto", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="datos_presupuestos_id_presupuesto_seq", allocationSize=1, initialValue=1)
     */
    private $idPresupuesto;


    /**
     * @var \AdTipoEgresos
     *
     * @ORM\ManyToOne(targetEntity="AdTipoEgresos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipo_egreso", referencedColumnName="id_tipo_egreso")
     * })
     */
    private $tipoEgreso;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_actividad_egreso", type="integer", nullable=true)
     */
    private $idActividadEgreso;

    /**
     * @var integer
     *
     * @ORM\Column(name="fuente_egreso", type="integer", nullable=true)
     */
    private $fuenteEgreso;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=256, nullable=true)
     */
    private $descripcion;

    /**
     * @var integer
     *
     * @ORM\Column(name="preparado_por", type="integer", nullable=false)
     */
    private $preparadoPor;

    /**
     * @var integer
     *
     * @ORM\Column(name="aprobado_por", type="integer", nullable=true)
     */
    private $aprobadoPor;


    /**
     * @var \AdEstadosPresupuesto
     *
     * @ORM\ManyToOne(targetEntity="AdEstadosPresupuesto")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="estado", referencedColumnName="id_estado_presupuesto")
     * })
     */
    private $estado;

    /**
     * @var string
     *
     * @ORM\Column(name="total_presupuesto_estimado", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $totalPresupuestoEstimado;

    /**
     * @var string
     *
     * @ORM\Column(name="total_presupuesto_ejecutado", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $totalPresupuestoEjecutado;

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
     * Get idPresupuesto
     *
     * @return integer 
     */
    public function getIdPresupuesto()
    {
        return $this->idPresupuesto;
    }

    /**
     * Set tipoEgreso
     *
     * @param integer $tipoEgreso
     * @return DatosPresupuestos
     */
    public function setTipoEgreso($tipoEgreso)
    {
        $this->tipoEgreso = $tipoEgreso;

        return $this;
    }

    /**
     * Get tipoEgreso
     *
     * @return integer 
     */
    public function getTipoEgreso()
    {
        return $this->tipoEgreso;
    }

    /**
     * Set idActividadEgreso
     *
     * @param integer $idActividadEgreso
     * @return DatosPresupuestos
     */
    public function setIdActividadEgreso($idActividadEgreso)
    {
        $this->idActividadEgreso = $idActividadEgreso;

        return $this;
    }

    /**
     * Get idActividadEgreso
     *
     * @return integer 
     */
    public function getIdActividadEgreso()
    {
        return $this->idActividadEgreso;
    }

    /**
     * Set fuenteEgreso
     *
     * @param integer $fuenteEgreso
     * @return DatosPresupuestos
     */
    public function setFuenteEgreso($fuenteEgreso)
    {
        $this->fuenteEgreso = $fuenteEgreso;

        return $this;
    }

    /**
     * Get fuenteEgreso
     *
     * @return integer 
     */
    public function getFuenteEgreso()
    {
        return $this->fuenteEgreso;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return DatosPresupuestos
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
     * Set preparadoPor
     *
     * @param integer $preparadoPor
     * @return DatosPresupuestos
     */
    public function setPreparadoPor($preparadoPor)
    {
        $this->preparadoPor = $preparadoPor;

        return $this;
    }

    /**
     * Get preparadoPor
     *
     * @return integer 
     */
    public function getPreparadoPor()
    {
        return $this->preparadoPor;
    }

    /**
     * Set aprobadoPor
     *
     * @param integer $aprobadoPor
     * @return DatosPresupuestos
     */
    public function setAprobadoPor($aprobadoPor)
    {
        $this->aprobadoPor = $aprobadoPor;

        return $this;
    }

    /**
     * Get aprobadoPor
     *
     * @return integer 
     */
    public function getAprobadoPor()
    {
        return $this->aprobadoPor;
    }

   
    /**
     * Set estado
     *
     * @param \Victoria\AppBundle\Entity\AdEstadosPresupuesto $idEstadoPresupuesto
     * @return DatosPresupuestos
     */
    public function setEstado(\Victoria\AppBundle\Entity\AdEstadosPresupuesto $idEstadoPresupuesto = null)
    {
        $this->estado = $idEstadoPresupuesto;

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
     * Set totalPresupuestoEstimado
     *
     * @param string $totalPresupuestoEstimado
     * @return DatosPresupuestos
     */
    public function setTotalPresupuestoEstimado($totalPresupuestoEstimado)
    {
        $this->totalPresupuestoEstimado = $totalPresupuestoEstimado;

        return $this;
    }

    /**
     * Get totalPresupuestoEstimado
     *
     * @return string 
     */
    public function getTotalPresupuestoEstimado()
    {
        return $this->totalPresupuestoEstimado;
    }

    /**
     * Set totalPresupuestoEjecutado
     *
     * @param string $totalPresupuestoEjecutado
     * @return DatosPresupuestos
     */
    public function setTotalPresupuestoEjecutado($totalPresupuestoEjecutado)
    {
        $this->totalPresupuestoEjecutado = $totalPresupuestoEjecutado;

        return $this;
    }

    /**
     * Get totalPresupuestoEjecutado
     *
     * @return string 
     */
    public function getTotalPresupuestoEjecutado()
    {
        return $this->totalPresupuestoEjecutado;
    }

    /**
     * Set idCampana
     *
     * @param \Victoria\AppBundle\Entity\DatosCampanasPoliticas $idCampana
     * @return DatosPresupuestos
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
     * @return DatosPresupuestos
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
