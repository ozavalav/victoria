<?php

namespace Victoria\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DatosRespuestasCuestionario
 *
 * @ORM\Table(name="datos_respuestas_cuestionario")
 * @ORM\Entity
 */
class DatosRespuestasCuestionario
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_respuesta_cuestionario", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="datos_respuestas_cuestionario_id_respuesta_cuestionario_seq", allocationSize=1, initialValue=1)
     */
    private $idRespuestaCuestionario;

    /**
     * @var string
     *
     * @ORM\Column(name="nombres", type="string", length=255, nullable=false)
     */
    private $nombres;

    /**
     * @var integer
     *
     * @ORM\Column(name="edad", type="integer", nullable=false)
     */
    private $edad;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=255, nullable=true)
     */
    private $direccion;

    /**
     * @var integer
     *
     * @ORM\Column(name="porque_partido_es_su_afinidad", type="integer", nullable=false)
     */
    private $porquePartidoEsSuAfinidad;

    /**
     * @var integer
     *
     * @ORM\Column(name="porque_partido_votara", type="integer", nullable=false)
     */
    private $porquePartidoVotara;

    /**
     * @var integer
     *
     * @ORM\Column(name="por_quien_votara_para_presidente", type="integer", nullable=false)
     */
    private $porQuienVotaraParaPresidente;

    /**
     * @var integer
     *
     * @ORM\Column(name="por_quien_votara_como_alcalde", type="integer", nullable=false)
     */
    private $porQuienVotaraComoAlcalde;

    /**
     * @var integer
     *
     * @ORM\Column(name="que_beneficio_le_gustaria_recibir_del_gobierno", type="integer", nullable=false)
     */
    private $queBeneficioLeGustariaRecibirDelGobierno;



    /**
     * Get idRespuestaCuestionario
     *
     * @return integer 
     */
    public function getIdRespuestaCuestionario()
    {
        return $this->idRespuestaCuestionario;
    }

    /**
     * Set nombres
     *
     * @param string $nombres
     * @return DatosRespuestasCuestionario
     */
    public function setNombres($nombres)
    {
        $this->nombres = $nombres;

        return $this;
    }

    /**
     * Get nombres
     *
     * @return string 
     */
    public function getNombres()
    {
        return $this->nombres;
    }

    /**
     * Set edad
     *
     * @param integer $edad
     * @return DatosRespuestasCuestionario
     */
    public function setEdad($edad)
    {
        $this->edad = $edad;

        return $this;
    }

    /**
     * Get edad
     *
     * @return integer 
     */
    public function getEdad()
    {
        return $this->edad;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     * @return DatosRespuestasCuestionario
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string 
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set porquePartidoEsSuAfinidad
     *
     * @param integer $porquePartidoEsSuAfinidad
     * @return DatosRespuestasCuestionario
     */
    public function setPorquePartidoEsSuAfinidad($porquePartidoEsSuAfinidad)
    {
        $this->porquePartidoEsSuAfinidad = $porquePartidoEsSuAfinidad;

        return $this;
    }

    /**
     * Get porquePartidoEsSuAfinidad
     *
     * @return integer 
     */
    public function getPorquePartidoEsSuAfinidad()
    {
        return $this->porquePartidoEsSuAfinidad;
    }

    /**
     * Set porquePartidoVotara
     *
     * @param integer $porquePartidoVotara
     * @return DatosRespuestasCuestionario
     */
    public function setPorquePartidoVotara($porquePartidoVotara)
    {
        $this->porquePartidoVotara = $porquePartidoVotara;

        return $this;
    }

    /**
     * Get porquePartidoVotara
     *
     * @return integer 
     */
    public function getPorquePartidoVotara()
    {
        return $this->porquePartidoVotara;
    }

    /**
     * Set porQuienVotaraParaPresidente
     *
     * @param integer $porQuienVotaraParaPresidente
     * @return DatosRespuestasCuestionario
     */
    public function setPorQuienVotaraParaPresidente($porQuienVotaraParaPresidente)
    {
        $this->porQuienVotaraParaPresidente = $porQuienVotaraParaPresidente;

        return $this;
    }

    /**
     * Get porQuienVotaraParaPresidente
     *
     * @return integer 
     */
    public function getPorQuienVotaraParaPresidente()
    {
        return $this->porQuienVotaraParaPresidente;
    }

    /**
     * Set porQuienVotaraComoAlcalde
     *
     * @param integer $porQuienVotaraComoAlcalde
     * @return DatosRespuestasCuestionario
     */
    public function setPorQuienVotaraComoAlcalde($porQuienVotaraComoAlcalde)
    {
        $this->porQuienVotaraComoAlcalde = $porQuienVotaraComoAlcalde;

        return $this;
    }

    /**
     * Get porQuienVotaraComoAlcalde
     *
     * @return integer 
     */
    public function getPorQuienVotaraComoAlcalde()
    {
        return $this->porQuienVotaraComoAlcalde;
    }

    /**
     * Set queBeneficioLeGustariaRecibirDelGobierno
     *
     * @param integer $queBeneficioLeGustariaRecibirDelGobierno
     * @return DatosRespuestasCuestionario
     */
    public function setQueBeneficioLeGustariaRecibirDelGobierno($queBeneficioLeGustariaRecibirDelGobierno)
    {
        $this->queBeneficioLeGustariaRecibirDelGobierno = $queBeneficioLeGustariaRecibirDelGobierno;

        return $this;
    }

    /**
     * Get queBeneficioLeGustariaRecibirDelGobierno
     *
     * @return integer 
     */
    public function getQueBeneficioLeGustariaRecibirDelGobierno()
    {
        return $this->queBeneficioLeGustariaRecibirDelGobierno;
    }
}
