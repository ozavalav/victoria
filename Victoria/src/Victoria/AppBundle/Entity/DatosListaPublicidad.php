<?php

namespace Victoria\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DatosListaPublicidad
 *
 * @ORM\Table(name="datos_lista_publicidad", indexes={@ORM\Index(name="IDX_E3532F41A051D29", columns={"id_publicidad"})})
 * @ORM\Entity
 */
class DatosListaPublicidad
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_lista", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="datos_lista_publicidad_id_lista_seq", allocationSize=1, initialValue=1)
     */
    private $idLista;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_anuncio", type="string", length=100, nullable=true)
     */
    private $tipoAnuncio;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=256, nullable=true)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="target", type="string", nullable=false)
     */
    private $target;

    /**
     * @var integer
     *
     * @ORM\Column(name="pauta_publicitaria", type="integer", nullable=false)
     */
    private $pautaPublicitaria;

    /**
     * @var integer
     *
     * @ORM\Column(name="personas_alcanzadas", type="integer", nullable=true)
     */
    private $personasAlcanzadas;

    /**
     * @var integer
     *
     * @ORM\Column(name="me_gusta", type="integer", nullable=true)
     */
    private $meGusta;

    /**
     * @var integer
     *
     * @ORM\Column(name="me_encanta", type="integer", nullable=true)
     */
    private $meEncanta;

    /**
     * @var integer
     *
     * @ORM\Column(name="me_divierte", type="integer", nullable=true)
     */
    private $meDivierte;

    /**
     * @var integer
     *
     * @ORM\Column(name="me_enoja", type="integer", nullable=true)
     */
    private $meEnoja;

    /**
     * @var integer
     *
     * @ORM\Column(name="me_entristece", type="integer", nullable=true)
     */
    private $meEntristece;

    /**
     * @var integer
     *
     * @ORM\Column(name="comentarios_positivos", type="integer", nullable=true)
     */
    private $comentariosPositivos;

    /**
     * @var integer
     *
     * @ORM\Column(name="comentarios_negativos", type="integer", nullable=true)
     */
    private $comentariosNegativos;

    /**
     * @var integer
     *
     * @ORM\Column(name="compartidos", type="integer", nullable=true)
     */
    private $compartidos;

   

    /**
     * @var integer
     *
     * @ORM\Column(name="id_publicidad", type="integer", nullable=false)
     */
    private $idPublicidad;



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
     * Set tipoAnuncio
     *
     * @param string $tipoAnuncio
     * @return DatosListaPublicidad
     */
    public function setTipoAnuncio($tipoAnuncio)
    {
        $this->tipoAnuncio = $tipoAnuncio;

        return $this;
    }

    /**
     * Get tipoAnuncio
     *
     * @return string 
     */
    public function getTipoAnuncio()
    {
        return $this->tipoAnuncio;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return DatosListaPublicidad
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
     * Set target
     *
     * @param string $target
     * @return DatosListaPublicidad
     */
    public function setTarget($target)
    {
        $this->target = $target;

        return $this;
    }

    /**
     * Get target
     *
     * @return string 
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Set pautaPublicitaria
     *
     * @param integer $pautaPublicitaria
     * @return DatosListaPublicidad
     */
    public function setPautaPublicitaria($pautaPublicitaria)
    {
        $this->pautaPublicitaria = $pautaPublicitaria;

        return $this;
    }

    /**
     * Get pautaPublicitaria
     *
     * @return integer 
     */
    public function getPautaPublicitaria()
    {
        return $this->pautaPublicitaria;
    }

    /**
     * Set personasAlcanzadas
     *
     * @param integer $personasAlcanzadas
     * @return DatosListaPublicidad
     */
    public function setPersonasAlcanzadas($personasAlcanzadas)
    {
        $this->personasAlcanzadas = $personasAlcanzadas;

        return $this;
    }

    /**
     * Get personasAlcanzadas
     *
     * @return integer 
     */
    public function getPersonasAlcanzadas()
    {
        return $this->personasAlcanzadas;
    }

    /**
     * Set meGusta
     *
     * @param integer $meGusta
     * @return DatosListaPublicidad
     */
    public function setMeGusta($meGusta)
    {
        $this->meGusta = $meGusta;

        return $this;
    }

    /**
     * Get meGusta
     *
     * @return integer 
     */
    public function getMeGusta()
    {
        return $this->meGusta;
    }

    /**
     * Set meEncanta
     *
     * @param integer $meEncanta
     * @return DatosListaPublicidad
     */
    public function setMeEncanta($meEncanta)
    {
        $this->meEncanta = $meEncanta;

        return $this;
    }

    /**
     * Get meEncanta
     *
     * @return integer 
     */
    public function getMeEncanta()
    {
        return $this->meEncanta;
    }

    /**
     * Set meDivierte
     *
     * @param integer $meDivierte
     * @return DatosListaPublicidad
     */
    public function setMeDivierte($meDivierte)
    {
        $this->meDivierte = $meDivierte;

        return $this;
    }

    /**
     * Get meDivierte
     *
     * @return integer 
     */
    public function getMeDivierte()
    {
        return $this->meDivierte;
    }

    /**
     * Set meEnoja
     *
     * @param integer $meEnoja
     * @return DatosListaPublicidad
     */
    public function setMeEnoja($meEnoja)
    {
        $this->meEnoja = $meEnoja;

        return $this;
    }

    /**
     * Get meEnoja
     *
     * @return integer 
     */
    public function getMeEnoja()
    {
        return $this->meEnoja;
    }

    /**
     * Set meEntristece
     *
     * @param integer $meEntristece
     * @return DatosListaPublicidad
     */
    public function setMeEntristece($meEntristece)
    {
        $this->meEntristece = $meEntristece;

        return $this;
    }

    /**
     * Get meEntristece
     *
     * @return integer 
     */
    public function getMeEntristece()
    {
        return $this->meEntristece;
    }

    /**
     * Set comentariosPositivos
     *
     * @param integer $comentariosPositivos
     * @return DatosListaPublicidad
     */
    public function setComentariosPositivos($comentariosPositivos)
    {
        $this->comentariosPositivos = $comentariosPositivos;

        return $this;
    }

    /**
     * Get comentariosPositivos
     *
     * @return integer 
     */
    public function getComentariosPositivos()
    {
        return $this->comentariosPositivos;
    }

    /**
     * Set comentariosNegativos
     *
     * @param integer $comentariosNegativos
     * @return DatosListaPublicidad
     */
    public function setComentariosNegativos($comentariosNegativos)
    {
        $this->comentariosNegativos = $comentariosNegativos;

        return $this;
    }

    /**
     * Get comentariosNegativos
     *
     * @return integer 
     */
    public function getComentariosNegativos()
    {
        return $this->comentariosNegativos;
    }

    /**
     * Set compartidos
     *
     * @param integer $compartidos
     * @return DatosListaPublicidad
     */
    public function setCompartidos($compartidos)
    {
        $this->compartidos = $compartidos;

        return $this;
    }

    /**
     * Get compartidos
     *
     * @return integer 
     */
    public function getCompartidos()
    {
        return $this->compartidos;
    }



    /**
     * Set idPublicidad
     *
     * @param integer $idPublicidad
     * @return DatosListaPublicidad
     */
    public function setIdPublicidad($idPublicidad)
    {
        $this->idPublicidad = $idPublicidad;

        return $this;
    }

    /**
     * Get idPublicidad
     *
     * @return integer
     */
    public function getIdPublicidad()
    {
        return $this->idPublicidad;
    }

}
