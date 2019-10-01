<?php

namespace Victoria\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AdMunicipios
 *
 * @ORM\Table(name="ad_municipios")
 * @ORM\Entity
 */
class AdMunicipios
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="ad_municipios_id_seq", allocationSize=1, initialValue=1)
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
     * @ORM\Column(name="cod_municipio", type="string", length=5, nullable=true)
     */
    private $codMunicipio;

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
     * @return AdMunicipios
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
     * Set codMunicipio
     *
     * @param string $codMunicipio
     *
     * @return AdMunicipios
     */
    public function setCodMunicipio($codMunicipio)
    {
        $this->codMunicipio = $codMunicipio;

        return $this;
    }

    /**
     * Get codMunicipio
     *
     * @return string
     */
    public function getCodMunicipio()
    {
        return $this->codMunicipio;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return AdMunicipios
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
