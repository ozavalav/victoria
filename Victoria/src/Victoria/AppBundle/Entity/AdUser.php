<?php

namespace Victoria\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

use Victoria\AppBundle\Entity\AdGroup;

/**
 * AdUser
 *
 * @ORM\Table(name="ad_user")
 * @ORM\Entity
 */
class AdUser implements AdvancedUserInterface, \Serializable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="ad_user_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=25, nullable=false)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=128, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=32, nullable=true)
     */
    private $salt;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_usuario", type="string", length=128, nullable=false)
     */
    private $nombreUsuario;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_estado", type="integer", nullable=false)
     */
    private $idEstado;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="acceso", type="integer", nullable=false)
     */
    private $acceso;

    /**
     * @var string
     *
     * @ORM\Column(name="cod_municipio", type="string", length=5, nullable=false)
     */
    private $codMunicipio;
    
    /**
     * @var string
     *
     * @ORM\Column(name="cod_departamento", type="string", length=3, nullable=false)
     */
    private $codDepartamento;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id_comunidad", type="integer", nullable=true)
     */
    private $idComunidad;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=true)
     */
    private $isActive;

    /**
     * @var string
     * 
     * @ORM\Column(name="email", type="string", length=128, nullable=true)
     * 
     */
    private $email;

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
     * @ORM\ManyToMany(targetEntity="Role")
     * @ORM\JoinTable(name="user_role",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     * )
     */
    private $user_roles;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id_estructura", type="integer", nullable=false)
     */
    private $idEstructura;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id_campana", type="integer", nullable=false)
     */
    private $idCampana;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id_distrito", type="integer", nullable=false)
     */
    private $idDistrito;
    

    public function __construct()
    {
        $this->isActive = true;
        $this->salt = md5(uniqid(null, true));
        //$this->groups = new ArrayCollection();
        $this->user_roles = new ArrayCollection();
    
        // puede no ser necesario, ver la sección salt debajo
        // $this->salt = md5(uniqid(null, true));
    }
    
     /**
     * Add user_roles
     *
     * @param Victoria\AppBundle\Entity\Role $userRoles
     */
    public function addRole(\Victoria\AppBundle\Entity\Role $userRoles)
    {
        $this->user_roles[] = $userRoles;
    }
 
    public function setUserRoles($roles) {
        $this->user_roles = $roles;
    }
    /**
     * Get user_roles
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getUserRoles()
    {
        return $this->user_roles;
    }
 
    /**
     * Get roles
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getRoles()
    {
        return $this->user_roles->toArray(); //IMPORTANTE: el mecanismo de seguridad de Sf2 requiere ésto como un array
    }
    
    /**
     * Compares this user to another to determine if they are the same.
     *
     * @param UserInterface $user The user
     * @return boolean True if equal, false othwerwise.
     */
    public function equals(UserInterface $user) {
        return md5($this->getUsername()) == md5($user->getUsername());
 
    }
    
    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            $this->isActive,
            // ver la sección salt debajo
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            $this->isActive,
            // ver la sección salt debajo
            // $this->salt
        ) = unserialize($serialized);
    }
    
    /**
     * Set id
     *
     * @param integer $id
     *
     * @return AdUser
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
    
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
     * Set username
     *
     * @param string $username
     *
     * @return AdUser
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return AdUser
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set salt
     *
     * @param string $salt
     *
     * @return AdUser
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set nombreUsuario
     *
     * @param string $nombreUsuario
     *
     * @return AdUser
     */
    public function setNombreUsuario($nombreUsuario)
    {
        $this->nombreUsuario = $nombreUsuario;

        return $this;
    }

    /**
     * Get nombreUsuario
     *
     * @return string
     */
    public function getNombreUsuario()
    {
        return $this->nombreUsuario;
    }

    /**
     * Set idEstado
     *
     * @param integer $idEstado
     *
     * @return AdUser
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
     * Set acceso
     *
     * @param integer $acceso
     *
     * @return AdUser
     */
    public function setAcceso($acceso)
    {
        $this->acceso = $acceso;

        return $this;
    }

    /**
     * Get acceso
     *
     * @return integer
     */
    public function getAcceso()
    {
        return $this->acceso;
    }
    
    /**
     * Set codMunicipio
     *
     * @param string $codMunicipio
     *
     * @return AdUser
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
     * Set codDepartamento
     *
     * @param string $codDepartamento
     *
     * @return AdUser
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
     * Set idComunidad
     *
     * @param integer $idComunidad
     *
     * @return AdUser
     */
    public function setIdComunidad($idComunidad)
    {
        $this->idComunidad = $idComunidad;

        return $this;
    }

    /**
     * Get idComunidad
     *
     * @return integer
     */
    public function getIdComunidad()
    {
        return $this->idComunidad;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return AdUser
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return AdUser
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return AdUser
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
     * @return AdUser
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
     * @return AdUser
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
     * @return AdUser
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
    
    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->isActive;
    }
        
    function __toString()
    {
        return $this->nombreUsuario;
    }
    
    /**
     * Set idEstructura
     *
     * @param integer $idEstructura
     *
     * @return AdUser
     */
    public function setIdEstructura($idEstructura)
    {
        $this->idEstructura = $idEstructura;

        return $this;
    }

    /**
     * Get idEstructura
     *
     * @return integer
     */
    public function getIdEstructura()
    {
        return $this->idEstructura;
    }
    
    /**
     * Set idCampana
     *
     * @param integer $idCampana
     *
     * @return AdUser
     */
    public function setIdCampana($idCampana)
    {
        $this->idCampana = $idCampana;

        return $this;
    }

    /**
     * Get idCampana
     *
     * @return integer
     */
    public function getIdCampana()
    {
        return $this->idCampana;
    }
    
    /**
     * Set idDistrito
     *
     * @param integer $idDistrito
     *
     * @return AdUser
     */
    public function setIdDistrito($idDistrito)
    {
        $this->idDistrito = $idDistrito;

        return $this;
    }

    /**
     * Get idDistrito
     *
     * @return integer
     */
    public function getIdDistrito()
    {
        return $this->idDistrito;
    }
}
