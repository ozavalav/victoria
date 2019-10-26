<?php

namespace Victoria\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\HttpFoundation\JsonResponse;

use Victoria\AppBundle\Entity\AdUser;
use Victoria\AppBundle\Form\AdUserType;
use Victoria\AppBundle\Entity\Role;
use Victoria\AppBundle\Entity\DatosPersonas;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

use Victoria\AppBundle\Entity\AppConst;


/**
 * AdUser controller.
 *
 */
class AdUserController extends Controller
{
    public function buscarMunicipioAction(Request $request, $param)
    {
        $em = $this->getDoctrine()->getManager();
        $response = new JsonResponse();
        $response->headers->set('Content-Type', 'application/json');
        
        $aldea = $param;
        $session = $request->getSession();
        $codMuni = $session->get('_cod_municipio');
        $codDep = $session->get('_cod_departamento');
        $codMuni = substr($codMuni, -2);
        $prmDep = str_pad($param, 2, "0", STR_PAD_LEFT);

    //IDENTITY
        $dql = 'SELECT mu.codMunicipio, mu.nombre
        FROM VictoriaAppBundle:AdMunicipios mu 
        WHERE mu.codDepartamento = ?1 
        order by mu.nombre';
        $query = $em->createQuery($dql);
        $query->setParameter(1, $prmDep);
        $municipios = $query->getResult();
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($municipios, 'json');
        $response->setData($municipios);
        return $response;
    }
    
    /* Busco los distritos segun la campaña politica selecciona */
    public function buscarDistritoAction(Request $request, $param)
    {
        $em = $this->getDoctrine()->getManager();
        $response = new JsonResponse();
        $response->headers->set('Content-Type', 'application/json');
        
        $prmCampana = $param;
        $session = $request->getSession();
        $codMuni = $session->get('_cod_municipio');
        $codDep = $session->get('_cod_departamento');
        $codMuni = substr($codMuni, -2);
        $prmDep = str_pad($param, 2, "0", STR_PAD_LEFT);
                
        $strwhere = '';
        if ($prmCampana != 0 ) {
            $strwhere = 'WHERE d.idCampana = '. $prmCampana;
        }

    //IDENTITY
        
        $dql = 'SELECT d.idDistrito, d.nombre
        FROM VictoriaAppBundle:DatosDistritos d %s order by d.nombre';
        $dql = sprintf($dql, $strwhere);
        $query = $em->createQuery($dql);
        //$query->setParameter(1, $prmCampana);
        $distritos = $query->getResult();
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($distritos, 'json');
        $response->setData($distritos);
        return $response;
    }
    
    /* Busco los distritos segun la campaña politica selecciona */
    public function buscarComisionAction(Request $request, $param)
    {
        $em = $this->getDoctrine()->getManager();
        $response = new JsonResponse();
        $response->headers->set('Content-Type', 'application/json');
        
        $prmEstructura = $param;
                
        $strwhere = '';
        if ($prmEstructura != 0 ) {
            $strwhere = 'WHERE d.idEstructura = '. $prmEstructura;
        }

    //IDENTITY
        
        $dql = 'SELECT d.idTipoComision, d.descripcion
        FROM VictoriaAppBundle:AdTiposComision d %s order by d.descripcion';
        $dql = sprintf($dql, $strwhere);
        $query = $em->createQuery($dql);
        //$query->setParameter(1, $prmCampana);
        $comisiones = $query->getResult();
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($comisiones, 'json');
        $response->setData($comisiones);
        return $response;
    }
    
    /* Busco los usuarios segun el distrito seleccionado */
    public function buscarUsuariosAction(Request $request, $param)
    {
        $em = $this->getDoctrine()->getManager();
        $response = new JsonResponse();
        $response->headers->set('Content-Type', 'application/json');
        
        $prmDistrito = $param;
        $session = $request->getSession();
        $codMuni = $session->get('_cod_municipio');
        $codDep = $session->get('_cod_departamento');
        $codMuni = substr($codMuni, -2);
        $prmDep = str_pad($param, 2, "0", STR_PAD_LEFT);
                
        $strwhere = '';
        if ($prmDistrito != 0 ) {
            $strwhere = 'WHERE d.idDistrito = '. $prmDistrito;
        }

    //IDENTITY
        
        $dql = 'SELECT d.id, d.username
        FROM VictoriaAppBundle:AdUser d %s order by d.username';
        $dql = sprintf($dql, $strwhere);
        $query = $em->createQuery($dql);
        //$query->setParameter(1, $prmCampana);
        $distritos = $query->getResult();
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($distritos, 'json');
        $response->setData($distritos);
        return $response;
    }    
    
    public function cambioestadoAction($param){
        $parametros = explode("&&", $param);
        $idUser= $parametros[0];
        $nestado= $parametros[1];

        $response = new JsonResponse();
        $em = $this->getDoctrine()->getManager();
        
        $entity = $em->getRepository('VictoriaAppBundle:AdUser')->find($idUser);
        
        if (!$entity) {
            throw $this->createNotFoundException('FOCAL: No se pudo encontrar el usuario.');
        }
                
        $usr= $this->get('security.context')->getToken()->getUser();
        $strgUsuario = $usr->getUsername();        
        $s = date('Y-m-d H:i:s');           

        $entity->setIdEstado($nestado);
        $entity->setIsActive(false);
        $entity->setUsuarioUltimaModificacion($strgUsuario);
        $entity->setFechaUltimaModificacion(new \DateTime($s));

        $em->flush();
        
        if (!$entity) {
            $response->setData(array('message' => 'false','razon' => 'FOCAL: Hubo un error al hacer el cambio'));
        } else {
          $response->setData(array('message' => 'true'));  
        }
        return $response;
    }
    
    private function setSecurePassword(&$entity) {
        $entity->setSalt(md5(time()));
        $encoder = new \Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder('sha512', true, 10);
        $password = $encoder->encodePassword($entity->getPassword(), $entity->getSalt());
        $entity->setPassword($password);
    }

    /**
     * Lists all AdUser entities.
     *
     */
    public function indexAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        
        $session = $request->getSession();
        $codMuni = $session->get('_cod_municipio');
        $menu = $session->get('_menu');

        $em = $this->getDoctrine()->getManager();

        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            $entities = $em->getRepository('VictoriaAppBundle:AdUser')->findBy(array('idEstado' => AppConst::ESTADO_GENERAL_ACTIVO));            
            } else {
                $entities = $em->getRepository('VictoriaAppBundle:AdUser')->findBy(array('idEstado' => AppConst::ESTADO_GENERAL_ACTIVO, 'codMunicipio' => $codMuni));
            }
            
        $dsql ="select de.codDepartamento, de.nombre "
                . "from VictoriaAppBundle:AdDepartamentos de "
                . "order by de.codDepartamento";
            $query = $em->createQuery($dsql);
            $departamentos = $query->getResult();     
        return $this->render('VictoriaAppBundle:AdUser:index.html.twig', array(
            'entities' => $entities,
            'departamentos' => $departamentos,
            'menu' => $menu
        ));
    }
    /**
     * Creates a new AdUser entity.
     *
     */
    public function createAction(Request $request)
    {
        $session = $request->getSession();
        $idEstructura = $session->get('_id_estructura');
        
        $entity = new AdUser();
        
        $form = $this->createCreateForm($entity, $idEstructura);
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $username = $entity->getUsername();
            $email = $entity->getEmail();
            
            $entusr = $em->getRepository('VictoriaAppBundle:AdUser')->findBy( array('username' => $username));
        
            if ($entusr) {
                throw $this->createNotFoundException('FOCAL: Usuario ya existe.');
            }
            
            /*$entusr = $em->getRepository('VictoriaAppBundle:AdUser')->findBy(array('email' => $email));
        
            if ($entusr) {
                throw $this->createNotFoundException('FOCAL: Usuario con ese correo ya existe.');
            }*/
            
            $this->setSecurePassword($entity);
            
            /* Guarda los valores por defecto */
            $usr= $this->get('security.context')->getToken()->getUser();
            $usuario = $usr->getUsername();
            $fecha = new \DateTime("now");
            $entity->setUsuarioCreacion($usuario);
            $entity->setUsuarioUltimaModificacion($usuario);
            $entity->setFechaCreacion($fecha);
            $entity->setFechaUltimaModificacion($fecha);
            $entity->setIdEstado(AppConst::ESTADO_GENERAL_ACTIVO);
            
            $session = $request->getSession();
            $codMuni = $session->get('_cod_municipio');
            $codDept = $session->get('_cod_departamento');
            $IdEstructura = $session->get('_id_estructura');
            $IdCampana = $session->get('_id_campana');
            $IdDistrito = $session->get('_id_distrito');
            $menu = $session->get('_menu');
            //$idComu = $session->get('_cod_comunidad');
            
            $entity->setAcceso($entity->getAcceso()->getIdRol());
            
            /* verifica si el usuario tiene privilegios para cambiar el departamento y municipio*/
            if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
                $entity->setCodDepartamento($entity->getCodDepartamento()->getCodDepartamento());
                $entity->setCodMunicipio($request->get('codmunicipio'));
                $entity->setIdCampana($entity->getIdCampana()->getIdCampana());
                $entity->setIdEstructura($entity->getIdEstructura()->getIdEstructura());
                $entity->setIdDistrito($request->get('iddistrito'));
            } else {
                $entity->setcodMunicipio($codMuni);
                $entity->setCodDepartamento($codDept);
                $entity->setIdEstructura($IdEstructura);
                $entity->setIdCampana($IdCampana);
                $entity->setIdDistrito($IdDistrito);
                //$entity->setidComunidad($idComu);
                /* La asigna rol de usuario */
                //$entity->setUserRoles(1);
            }
            
            /* ----------------------------------------------------------------------------
             * Al ingresa un usuario se crea una fila automaticamente a la tabla de personas 
             * ----------------------------------------------------------------------------
             */
            $entper = new DatosPersonas();
            $entper->setNombres($entity->getNombreUsuario());
            $entper->setNumeroIdentidad($request->get('focal_appbundle_aduser')['numeroidentidad']);
            $entper->setTelefono1($request->get('focal_appbundle_aduser')['telefono1']);
            $entper->setTelefono2($request->get('focal_appbundle_aduser')['telefono2']);
            $entper->setTelefono3($request->get('focal_appbundle_aduser')['telefono3']);
            $entper->setEmail($entity->getEmail());
            $entper->setIdEstructura($request->get('focal_appbundle_aduser')['idEstructura']);
            $entper->setIdComision($request->get('focal_appbundle_aduser')['idComision']);
            
            $val = $request->get('focal_appbundle_aduser')['idCampana'];
            $enttmp = $em->getRepository('VictoriaAppBundle:DatosCampanasPoliticas')->findBy(array('idCampana' => $val));
            $entper->setIdCampana($enttmp[0]);
            $val = $request->get('iddistrito');
            $enttmp = $em->getRepository('VictoriaAppBundle:DatosDistritos')->findBy(array('idDistrito' => $val));
            $entper->setIdDistrito($enttmp[0]);
            
            $entper->setEstado(1); //1 = Activo
            
            $em->persist($entper);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('aduser'));
        }

        return $this->render('VictoriaAppBundle:AdUser:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'menu' => $menu
        ));
    }

    /**
     * Creates a form to create a AdUser entity.
     *
     * @param AdUser $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(AdUser $entity, $idEstructura = 0)
    {
        $form = $this->createForm(new AdUserType(), $entity, array(
            'action' => $this->generateUrl('aduser_create'),
            'method' => 'POST',
        ));
        
        $form
            ->add('numeroidentidad',null, array('mapped' => false, 'label'=> 'Número Identidad', 'attr' => array('required' => true, 'maxlength' => 20, 'placeholder' => 'Número identidad')))
            ->add('telefono1',null, array('mapped' => false, 'label'=> 'Número Teléfono', 'attr' => array('required' => true, 'maxlength' => 12, 'placeholder' => 'Número de teléfono 1')))
            ->add('telefono2',null, array('mapped' => false, 'label'=> 'Número Teléfono', 'attr' => array('maxlength' => 12, 'placeholder' => 'Número de teléfono 2')))
            ->add('telefono3',null, array('mapped' => false, 'label'=> 'Número Teléfono', 'attr' => array('maxlength' => 12, 'placeholder' => 'Número de teléfono 3')))
            ->add('idComision',EntityType::class,array(
            'mapped' => false,    
            'class' => 'VictoriaAppBundle:AdTiposComision',
            'label' => 'Comision',    
            'attr' => array('required' => true),
            'query_builder' => function (EntityRepository $er) use ($idEstructura) {
                return $er->createQueryBuilder('c')  
                    ->where('c.idEstructura >= ?1')    
                    ->orderBy('c.descripcion')
                    ->setParameter(1,$idEstructura);
                }
            ))     
            ->add('submit', 'submit', array('label' => 'Guardar', 'attr' => array('class' => 'btn-success')));

        return $form;
    }

    /**
     * Displays a form to create a new AdUser entity.
     *
     */
    public function newAction(Request $request)
    {
        $session = $request->getSession();
        $menu = $session->get('_menu');
        $idEstructura = $session->get('_id_estructura');
        
        $entity = new AdUser();
        $form   = $this->createCreateForm($entity, $idEstructura);

        return $this->render('VictoriaAppBundle:AdUser:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'menu' => $menu,
        ));
    }

    /**
     * Finds and displays a AdUser entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:AdUser')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AdUser entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VictoriaAppBundle:AdUser:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing AdUser entity.
     *
     */
    public function editAction(Request $request, $id)
    {
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:AdUser')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AdUser entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);
            
        return $this->render('VictoriaAppBundle:AdUser:edit.html.twig', array(
            'entity'      => $entity,
            'codDep'      => $entity->getCodDepartamento(),
            'codMun'      => $entity->getCodMunicipio(),
            'acceso'      => $entity->getAcceso(),
            'idEstructura' => $entity->getIdEstructura(),
            'idCampana' => $entity->getIdCampana(),
            'idDistrito' => $entity->getIdDistrito(),
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'menu' => $menu,
        ));
    }

    /**
    * Creates a form to edit a AdUser entity.
    *
    * @param AdUser $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(AdUser $entity)
    {
        $form = $this->createForm(new AdUserType(), $entity, array(
            'action' => $this->generateUrl('aduser_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar', 'attr' => array('class' => 'btn-success')));

        return $form;
    }
    /**
     * Edits an existing AdUser entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:AdUser')->find($id);
        
        if (!$entity) {
            throw $this->createNotFoundException('VICTORIA: No se pudo encontrar el usuario.');
        }
        
        //obtiene la contraseña y email actuales -----------------------
        $current_pass = $entity->getPassword();
        $email_actual = $entity->getEmail();
        $username_actual = $entity->getUsername();
        $codDeptoAnt = $entity->getCodDepartamento();
        $codMuniAnt = $entity->getCodMunicipio();
        $idEstructuraAnt = $entity->getIdEstructura();
        $idCampanaAnt = $entity->getIdCampana();
        $idDistritoAnt = $entity->getIdDistrito();
        $accesoAnt = $entity->getAcceso();
        
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        
        $editForm->handleRequest($request);
        
        if ($email_actual != $entity->getEmail()) {
            
            $dsql ='select u.username from VictoriaAppBundle:AdUser u '
            . 'where u.email = :p_email and u.id <> :p_iduser ';
            $query = $em->createQuery($dsql);
            $query ->setParameter('p_email', $entity->getEmail());
            $query ->setParameter('p_iduser', $entity->getId());
            $entusr = $query->getResult();
            
            //$entusr = $em->getRepository('VictoriaAppBundle:AdUser')->findBy(array('email' => $email_actual));
            if ($entusr) {
                $this->addFlash('alert-warning','Victoria: Ya existe un usuario con el mismo correo!' );
                return $this->render('VictoriaAppBundle:AdUser:edit.html.twig', array(
                    'entity'      => $entity,
                    'codDep'      => $codDeptoAnt,
                    'codMun'      => $codMuniAnt,
                    'edit_form'   => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
                ));
            }    //throw $this->createNotFoundException('FOCAL: Ya existe un usuario con el mismo correo.');
        }
        
        
        if ($editForm->isValid()) {
            //evalua si la contraseña fue modificada: ------------------------
            $pass_ingresado = $entity->getPassword();
            if ($current_pass != (isset($pass_ingresado))? $pass_ingresado : $current_pass) {
                $this->setSecurePassword($entity);
            } else {
                $entity->setPassword($current_pass);
            }
            
            $entity->setUsername($username_actual);
            
            $accesoAct = $entity->getAcceso()->getIdRol();
            $entity->setAcceso($accesoAnt);
            
            /* verifica si el usuario tiene privilegios para cambiar el departamento */
            if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
                if(!$entity->getCodDepartamento()) {
                    $entity->setCodDepartamento($codDeptoAnt);
                    $entity->setCodMunicipio($codMuniAnt);
                }else {
                    $entity->setCodDepartamento($entity->getCodDepartamento()->getCodDepartamento());
                    $entity->setIdCampana($entity->getIdCampana()->getIdCampana());
                    $entity->setIdEstructura($entity->getIdEstructura()->getIdEstructura());
                    $entity->setCodMunicipio($request->get('codmunicipio'));
                    $entity->setIdDistrito($request->get('iddistrito'));
                    $entity->setAcceso($accesoAct);
                }
            } else {
                $entity->setCodDepartamento($codDeptoAnt);
                $entity->setCodMunicipio($codMuniAnt);
                $entity->setIdEstructura($idEstructuraAnt);
                $entity->setIdCampana($idCampanaAnt);
                $entity->setIdDistrito($idDistritoAnt);
                $entity->setAcceso($accesoAnt);
            }
            
            /* Guarda los valores por defecto */
            $usr= $this->get('security.context')->getToken()->getUser();
            $usuario = $usr->getUsername();
            $fecha = new \DateTime("now");
            $entity->setUsuarioUltimaModificacion($usuario);
            $entity->setFechaUltimaModificacion($fecha);
            
            $em->flush();

            $this->addFlash('alert-success','Datos actualizados con exito!' );
            return $this->redirect($this->generateUrl('aduser_edit', array('id' => $id)));
        }
        //return $this->redirect($this->generateUrl('aduser_edit', array('id' => $id)));
        return $this->render('VictoriaAppBundle:AdUser:edit.html.twig', array(
            'entity'      => $entity,
            'codDep'      => $codDeptoAnt,
            'codMun'      => $codMuniAnt,
            'idDistrito'  => $idDistritoAnt,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a AdUser entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('VictoriaAppBundle:AdUser')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find AdUser entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('aduser'));
    }

    /**
     * Creates a form to delete a AdUser entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('aduser_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
