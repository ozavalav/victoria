<?php

namespace Victoria\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AdDepartamentos
 *
 * @ORM\Table(name="ad_departamentos")
 * @ORM\Entity
 */
class AdDepartamentos
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="ad_departamentos_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="cod_departamento", type="string", length=5, nullable=true)
     */
    private $codDepartamento;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=64, nullable=true)
     */
    private $nombre;



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set codDepartamento
     *
     * @param string $codDepartamento
     *
     * @return AdDepartamentos
     */
    public function setCodDepartamento($codDepartamento)
    {
        $this->codDepartamento = $codDepartamento;

        return $this;
    }

    /**
     * Get codDepartamento
     *
     * @return string
     */
    public function getCodDepartamento()
    {
        return $this->codDepartamento;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return AdDepartamentos
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
}
