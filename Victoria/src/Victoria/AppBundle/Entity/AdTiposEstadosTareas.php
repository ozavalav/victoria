<?php

namespace Victoria\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AdTiposEstadosTareas
 *
 * @ORM\Table(name="ad_tipos_estados_tareas")
 * @ORM\Entity
 */
class AdTiposEstadosTareas
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_tipo_estado_tareas", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="ad_tipos_estados_tareas_id_tipo_estado_tareas_seq", allocationSize=1, initialValue=1)
     */
    private $idTipoEstadoTareas;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", nullable=false)
     */
    private $descripcion;



    /**
     * Get idTipoEstadoTareas
     *
     * @return integer 
     */
    public function getIdTipoEstadoTareas()
    {
        return $this->idTipoEstadoTareas;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return AdTiposEstadosTareas
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
        function __toString()
    {
        return $this->descripcion;
    }
}
