<?php

namespace Victoria\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AdPeriodos
 *
 * @ORM\Table(name="ad_periodo")
 * @ORM\Entity
 */
class AdPeriodos
{
    /**
     * @var smallint
     *
     * @ORM\Column(name="periodo", type="smallint", nullable=false)
     * @ORM\Id
     */
    private $periodo;

    /**
     * @var smallint
     *
     * @ORM\Column(name="estado", type="smallint", nullable=true)
     */
    private $estado;


    /**
     * Set periodo
     *
     * @param smallint $periodo
     *
     * @return AdPeriodos
     */
    public function setPeriodo($periodo)
    {
        $this->periodo = $periodo;

        return $this;
    }

    /**
     * Get periodo
     *
     * @return smallint
     */
    public function getPeriodo()
    {
        return $this->periodo;
    }
    
    /**
     * Set estado
     *
     * @param smallint $estado
     *
     * @return AdPeriodos
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return smallint
     */
    public function getEstado()
    {
        return $this->estado;
    }
}
