<?php

namespace Victoria\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DatosComentariosPresupuesto
 *
 * @ORM\Table(name="datos_comentarios_presupuesto", indexes={@ORM\Index(name="IDX_FBAC0949371A524", columns={"id_presupuesto"})})
 * @ORM\Entity
 */
class DatosComentariosPresupuesto
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_comentario", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="datos_comentarios_presupuesto_id_comentario_seq", allocationSize=1, initialValue=1)
     */
    private $idComentario;

    /**
     * @var string
     *
     * @ORM\Column(name="mensaje", type="string", length=512, nullable=true)
     */
    private $mensaje;

    /**
     * @var string
     *
     * @ORM\Column(name="archivo", type="string", length=256, nullable=true)
     */
    private $archivo;

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
     * @var string
     *
     * @ORM\Column(name="usuario", type="string", length=25, nullable=false)
     */
    private $usuario;   

    /**
     * Get idComentario
     *
     * @return integer 
     */
    public function getIdComentario()
    {
        return $this->idComentario;
    }

    /**
     * Set mensaje
     *
     * @param string $mensaje
     * @return DatosComentariosPresupuesto
     */
    public function setMensaje($mensaje)
    {
        $this->mensaje = $mensaje;

        return $this;
    }

    /**
     * Get mensaje
     *
     * @return string 
     */
    public function getMensaje()
    {
        return $this->mensaje;
    }

    /**
     * Set archivo
     *
     * @param string $archivo
     * @return DatosComentariosPresupuesto
     */
    public function setArchivo($archivo)
    {
        $this->archivo = $archivo;

        return $this;
    }

    /**
     * Get archivo
     *
     * @return string 
     */
    public function getArchivo()
    {
        return $this->archivo;
    }

    /**
     * Set idPresupuesto
     *
     * @param \Victoria\AppBundle\Entity\DatosPresupuestos $idPresupuesto
     * @return DatosComentariosPresupuesto
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
    
    /**
     * Set usuario
     *
     * @param string usuario
     *
     * @return DatosComentariosPresupuesto
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsuario()
    {
        return $this->usuario;
    }    
}
