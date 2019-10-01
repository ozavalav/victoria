<?php

namespace Victoria\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DatosComisiones
 *
 * @ORM\Table(name="datos_comisiones", indexes={@ORM\Index(name="idx_datos_comisiones", columns={"id_estructura", "id_tipo_comision", "id_campana", "id_persona"}), @ORM\Index(name="IDX_9D08C49FB8445919", columns={"id_campana"}), @ORM\Index(name="IDX_9D08C49FFFABC0C8", columns={"id_estructura"}), @ORM\Index(name="IDX_9D08C49F8F781FEB", columns={"id_persona"}), @ORM\Index(name="IDX_9D08C49F78FE02C3", columns={"id_tipo_comision"})})
 * @ORM\Entity
 */
class DatosComisiones
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_comision", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="datos_comisiones_id_comision_seq", allocationSize=1, initialValue=1)
     */
    private $idComision;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=256, nullable=true)
     */
    private $descripcion;

    /**
     * @var \DatosDistritos
     *
     * @ORM\ManyToOne(targetEntity="DatosDistritos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_distrito", referencedColumnName="id_distrito")
     * })
     */
    private $idDistrito = '0';

    /**
     * @var \DatosCentrosVotacion
     *
     * @ORM\ManyToOne(targetEntity="DatosCentrosVotacion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_cv", referencedColumnName="id_cv")
     * })
     */
    private $idCv = '0';

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
     * @var \DatosEstructuras
     *
     * @ORM\ManyToOne(targetEntity="DatosEstructuras")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_estructura", referencedColumnName="id_estructura")
     * })
     */
    private $idEstructura;

    /**
     * @var \DatosPersonas
     *
     * @ORM\ManyToOne(targetEntity="DatosPersonas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_persona", referencedColumnName="id_persona")
     * })
     */
    private $idPersona;

    /**
     * @var \AdTiposComision
     *
     * @ORM\ManyToOne(targetEntity="AdTiposComision")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_tipo_comision", referencedColumnName="id_tipo_comision")
     * })
     */
    private $idTipoComision;


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
     * Set descripcion
     *
     * @param string $descripcion
     * @return DatosComisiones
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
     * Set idDistrito
     *
     * @param \Victoria\AppBundle\Entity\DatosCampanasPoliticas $idDistrito
     * @return DatosComisiones
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

     /**
     * Set idCv
     *
     * @param \Victoria\AppBundle\Entity\DatosCentrosVotacion $idCv
     * @return DatosComisiones
     */
    public function setIdCv(\Victoria\AppBundle\Entity\DatosCentrosVotacion $idCv = null)
    {
        $this->idCv = $idCv;

        return $this;
    }

    /**
     * Get idCv
     *
     * @return \Victoria\AppBundle\Entity\DatosCentrosVotacion 
     */
    public function getIdCv()
    {
        return $this->idCv;
    }
    

    /**
     * Set idCampana
     *
     * @param \Victoria\AppBundle\Entity\DatosCampanasPoliticas $idCampana
     * @return DatosComisiones
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
     * Set idEstructura
     *
     * @param \Victoria\AppBundle\Entity\DatosEstructuras $idEstructura
     * @return DatosComisiones
     */
    public function setIdEstructura(\Victoria\AppBundle\Entity\DatosEstructuras $idEstructura = null)
    {
        $this->idEstructura = $idEstructura;

        return $this;
    }

    /**
     * Get idEstructura
     *
     * @return \Victoria\AppBundle\Entity\DatosEstructuras 
     */
    public function getIdEstructura()
    {
        return $this->idEstructura;
    }

    /**
     * Set idPersona
     *
     * @param \Victoria\AppBundle\Entity\DatosPersonas $idPersona
     * @return DatosComisiones
     */
    public function setIdPersona(\Victoria\AppBundle\Entity\DatosPersonas $idPersona = null)
    {
        $this->idPersona = $idPersona;

        return $this;
    }

    /**
     * Get idPersona
     *
     * @return \Victoria\AppBundle\Entity\DatosPersonas 
     */
    public function getIdPersona()
    {
        return $this->idPersona;
    }

    /**
     * Set idTipoComision
     *
     * @param \Victoria\AppBundle\Entity\AdTiposComision $idTipoComision
     * @return DatosComisiones
     */
    public function setIdTipoComision(\Victoria\AppBundle\Entity\AdTiposComision $idTipoComision = null)
    {
        $this->idTipoComision = $idTipoComision;

        return $this;
    }

    /**
     * Get idTipoComision
     *
     * @return \Victoria\AppBundle\Entity\AdTiposComision 
     */
    public function getIdTipoComision()
    {
        return $this->idTipoComision;
    }
}
