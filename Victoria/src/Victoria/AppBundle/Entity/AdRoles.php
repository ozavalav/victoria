<?php

namespace Victoria\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AdRoles
 *
 * @ORM\Table(name="ad_roles", uniqueConstraints={@ORM\UniqueConstraint(name="uq_ad_acceso_acceso", columns={"rol"})})
 * @ORM\Entity
 */
class AdRoles
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_rol", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="ad_roles_id_rol_seq", allocationSize=1, initialValue=1)
     */
    private $idRol;

    /**
     * @var string
     *
     * @ORM\Column(name="rol", type="string", length=128, nullable=false)
     */
    private $rol;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_estado", type="integer", nullable=false)
     */
    private $idEstado;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_creacion", type="datetime", nullable=false)
     */
    private $fechaCreacion;

    /**
     * @var string
     *
     * @ORM\Column(name="usuario_creacion", type="string", length=32, nullable=false)
     */
    private $usuarioCreacion;

    /**
     * @var string
     *
     * @ORM\Column(name="usuario_ultima_modificacion", type="string", length=32, nullable=false)
     */
    private $usuarioUltimaModificacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_ultima_modificacion", type="datetime", nullable=false)
     */
    private $fechaUltimaModificacion;



    /**
     * Get idRol
     *
     * @return integer
     */
    public function getIdRol()
    {
        return $this->idRol;
    }

    /**
     * Set rol
     *
     * @param string $rol
     *
     * @return AdRoles
     */
    public function setRol($rol)
    {
        $this->rol = $rol;

        return $this;
    }

    /**
     * Get rol
     *
     * @return string
     */
    public function getRol()
    {
        return $this->rol;
    }

    /**
     * Set idEstado
     *
     * @param integer $idEstado
     *
     * @return AdRoles
     */
    public function setIdEstado($idEstado)
    {
        $this->idEstado = $idEstado;

        return $this;
    }

    /**
     * Get idEstado
     *
     * @return integer
     */
    public function getIdEstado()
    {
        return $this->idEstado;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return AdRoles
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    /**
     * Get fechaCreacion
     *
     * @return \DateTime
     */
    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
    }

    /**
     * Set usuarioCreacion
     *
     * @param string $usuarioCreacion
     *
     * @return AdRoles
     */
    public function setUsuarioCreacion($usuarioCreacion)
    {
        $this->usuarioCreacion = $usuarioCreacion;

        return $this;
    }

    /**
     * Get usuarioCreacion
     *
     * @return string
     */
    public function getUsuarioCreacion()
    {
        return $this->usuarioCreacion;
    }

    /**
     * Set usuarioUltimaModificacion
     *
     * @param string $usuarioUltimaModificacion
     *
     * @return AdRoles
     */
    public function setUsuarioUltimaModificacion($usuarioUltimaModificacion)
    {
        $this->usuarioUltimaModificacion = $usuarioUltimaModificacion;

        return $this;
    }

    /**
     * Get usuarioUltimaModificacion
     *
     * @return string
     */
    public function getUsuarioUltimaModificacion()
    {
        return $this->usuarioUltimaModificacion;
    }

    /**
     * Set fechaUltimaModificacion
     *
     * @param \DateTime $fechaUltimaModificacion
     *
     * @return AdRoles
     */
    public function setFechaUltimaModificacion($fechaUltimaModificacion)
    {
        $this->fechaUltimaModificacion = $fechaUltimaModificacion;

        return $this;
    }

    /**
     * Get fechaUltimaModificacion
     *
     * @return \DateTime
     */
    public function getFechaUltimaModificacion()
    {
        return $this->fechaUltimaModificacion;
    }
}
