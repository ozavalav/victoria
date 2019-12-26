<?php

namespace Victoria\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DatosComisionesAsignadas
 *
 * @ORM\Table(name="datos_comisiones_asignadas")
 * @ORM\Entity
 */
class DatosComisionesAsignadas
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_comision", type="integer", nullable=false)
     * @ORM\Id
     */
    private $idComision;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_persona", type="integer", nullable=true)
     */
    private $idPersona;


    /**
     * Set idComision
     *
     * @param integer $idComision
     * @return DatosComisionesAsignadas
     */
    public function setIdComision($idComision)
    {
        $this->idComision = $idComision;

        return $this;
    }
    
    /**
     * Get idComision
     *
     * @return integer 
     */
    public function getIdComision()
    {
        return $this->idComision;
    }

    /**
     * Set idPersona
     *
     * @param integer $idPersona
     * @return DatosComisionesAsignadas
     */
    public function setIdPersona($idPersona)
    {
        $this->idPersona = $idPersona;

        return $this;
    }

    /**
     * Get idPersona
     *
     * @return integer 
     */
    public function getIdPersona()
    {
        return $this->idPersona;
    }
}
