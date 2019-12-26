<?php

namespace Victoria\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Victoria\AppBundle\Entity\DatosCampanasPoliticas;
use Victoria\AppBundle\Entity\DatosComisionesCantidad;
use Victoria\AppBundle\Entity\DatosComisionesAsignadas;
use Victoria\AppBundle\Form\DatosCampanasPoliticasType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * DatosCampanasPoliticas controller.
 *
 */
class DatosCampanasPoliticasController extends Controller
{

    /**
     * Lists all DatosCampanasPoliticas entities.
     *
     */
    public function indexAction(Request $request)
    {
        $seg = $this->container->get('victoria_app.vicseguridad');
        
        /* Verifica que el usuario este autenticado */
        $ok = $seg->validarUsuario();
        
        /* Verifica que el usuario tenga acceso a esta ruta o opción */
        $ruta = $request->attributes->get('_route'); 
        $ok = $seg->comprobarAcceso($ruta);
        
        /* Carga las variables de sesion del usuarios necesarias para dibujar menu y filtar la información */
        $session = $request->getSession();
        $menu = $session->get('_menu');
        $idCampana = $session->get('_id_campana');
        $idDistrito = $session->get('_id_distrito');
        $idUsuario = $session->get('_id_usuario');
        
        /* Obtiene las notificaciones que tiene el usuario */
        $entnot = $seg->obtenerNotificaciones($idUsuario);
        /* Obtiene las tareas que tiene el usuario */
        $enttar = $seg->obtenerTareas($idUsuario);
        
        $em = $this->getDoctrine()->getManager();

        if($idCampana == 0 && $idDistrito == 0) {
            //$entities = $em->getRepository('VictoriaAppBundle:DatosCampanasPoliticas')->findAll();
            $query = "select cp.id_campana, cp.nombre, cp.candidato, ccp.total_campanas, acp.total_asignadas, vot.votantes, ce.carga  
                from datos_campanas_politicas cp
left join (
	select id_estructura, sum(cantidad) total_campanas
	from datos_comisiones_cantidad
	where tipo_estructura = 1
	group by id_estructura
) ccp on (cp.id_campana = ccp.id_estructura)
left join (
	select id_estructura, count(*) total_asignadas 
	from datos_comisiones_cantidad cc join datos_comisiones_asignadas ca on (cc.id_comision = ca.id_comision)
	where cc.tipo_estructura = 1
	group by id_estructura
) acp on (cp.id_campana = acp.id_estructura)
left join (
	select cv.id_campana, count(*) votantes
	from datos_votantes dv join datos_centros_votacion cv on (cv.id_cv = dv.id_cv ) 
	group by id_campana
) vot on (vot.id_campana = cp.id_campana)
left join (
	select id_campana, sum(cargar_electoral) carga
	from datos_centros_votacion
	where id_campana <> 0 
	group by id_campana
) ce on (ce.id_campana = cp.id_campana)
where cp.id_campana <> 0 
";
        $stmt = $em->getConnection()->prepare($query);
        //$stmt->bindValue('idcmp',$idCampana);
        $stmt->execute();
        $entities = $stmt->fetchAll();
            
        //} elseif($idCampana != 0 && $idDistrito == 0 ) {
            //$entities = $em->getRepository('VictoriaAppBundle:DatosCampanasPoliticas')->findBy(['idCampana' => $idCampana]);
        } else {
            //$entities = $em->getRepository('VictoriaAppBundle:DatosCampanasPoliticas')->findBy(['idCampana' => $idCampana]);
$query = "select cp.id_campana, cp.nombre, cp.candidato, ccp.total_campanas, acp.total_asignadas, vot.votantes, ce.carga 
    from datos_campanas_politicas cp
left join (
	select id_estructura, sum(cantidad) total_campanas
	from datos_comisiones_cantidad
	where tipo_estructura = 1
	group by id_estructura
) ccp on (cp.id_campana = ccp.id_estructura)
left join (
	select id_estructura, count(*) total_asignadas 
	from datos_comisiones_cantidad cc join datos_comisiones_asignadas ca on (cc.id_comision = ca.id_comision)
	where cc.tipo_estructura = 1
	group by id_estructura
) acp on (cp.id_campana = acp.id_estructura)
left join (
	select cv.id_campana, count(*) votantes
	from datos_votantes dv join datos_centros_votacion cv on (cv.id_cv = dv.id_cv ) 
	group by id_campana
) vot on (vot.id_campana = cp.id_campana)
left join (
	select id_campana, sum(cargar_electoral) carga
	from datos_centros_votacion
	where id_campana <> 0 
	group by id_campana
) ce on (ce.id_campana = cp.id_campana)
where cp.id_campana = :idcmp
";
        $stmt = $em->getConnection()->prepare($query);
        $stmt->bindValue('idcmp',$idCampana);
        $stmt->execute();
        $entities = $stmt->fetchAll(); 
        
        }
        return $this->render('VictoriaAppBundle:DatosCampanasPoliticas:index.html.twig', array(
            'entities' => $entities,
            'menu' => $menu,
            'datosnoti' => $entnot,
            'datostar' => $enttar,
            
        ));
    }
    /**
     * Creates a new DatosCampanasPoliticas entity.
     * 
     */
    public function createAction(Request $request)
    {
        $entity = new DatosCampanasPoliticas();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('datoscampanaspoliticas_show', array('id' => $entity->getIdCampana())));
        }

        return $this->render('VictoriaAppBundle:DatosCampanasPoliticas:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }
    
        /**
        * Creates a new DatosComisionesCantidad entity.
        *
        */
       public function createcantAction(Request $request)
    {
        $session = $request->getSession();
        $idCampana = $session->get('_id_campana');
        $idUsuario = $session->get('_id_usuario');
        $menu = $session->get('_menu');
                
        $em = $this->getDoctrine()->getManager();
        
        /* Obtiene la cantidad de comisiones para la estructura C */
        $query = "select * from ad_tipos_comision where id_estructura = 1";
        $stmt = $em->getConnection()->prepare($query);
        $stmt->execute();
        $entcantcomi = $stmt->fetchAll();
        
        if (!$entcantcomi) {
            throw $this->createNotFoundException('No se encontro datos en la cantidad de comisiones por CV.');
        }
        
        $idestructura_campanapolitica = $request->get('idestructura');
        foreach( $entcantcomi as $comi) {
            /* Comprobar si la comision existe o es nueva 
             * si existe actualizo los datos
             * en caso contrario creo una nueva entidad
             * Nota: se crearan todas las comisiones para cada CV si no tiene
             * personas participantes o no necesita la comision la cantidad sera = 0
             */
            
            $idcomision = $request->get('idcomision_'.$comi['id_tipo_comision']);
            $cantidad = $request->get('cantidad_'.$comi['id_tipo_comision']);
            /* si la comision no existe entonces se crea una nueva
             * en caso contrario se acualizan los valores 
             */
            if (empty($idcomision)) {
                $entity = new DatosComisionesCantidad();
                $idtipocomision = $comi['id_tipo_comision'];
                
                $entity->setCantidad($cantidad);
                $entity->setIdEstructura($idestructura_campanapolitica);
                $entity->setIdTipoComision($idtipocomision);
                $entity->setTipoEstructura(1); // 3 = Centro de votacion, 2 = Distritos , 1 = Campañas
                
                $em->persist($entity);
            } else {
                $entity = $em->getRepository('VictoriaAppBundle:DatosComisionesCantidad')->find($idcomision);
                
                if (!$entity) {
                    throw $this->createNotFoundException('No se encontro datos en la cantidad de comisiones por CV. para editar');
                }
                $entity->setCantidad($cantidad);
                $em->flush();
            }
        }
            
        $em->flush();
        
        return $this->redirect($this->generateUrl('datoscampanaspoliticas_cantidad', array('id' => $idestructura_campanapolitica)));
    }
    
    /**
     * Creates a new DatosComisionesCantidad entity.
     *
     */
    public function asignarpersonaAction(Request $request)
    {
        $session = $request->getSession();
        $idCampana = $session->get('_id_campana');
        $idUsuario = $session->get('_id_usuario');
        $menu = $session->get('_menu');
                
        $em = $this->getDoctrine()->getManager();
        $idcomision = $request->get('idcomision');
        $idpersona = $request->get('persona');
        $idestructuracampanapolitica = $request->get('idestructuracampanapolitica');

        $entity = new DatosComisionesAsignadas();

        $entity->setIdPersona($idpersona);
        $entity->setIdComision($idcomision);    
        $em->persist($entity);
        $em->flush();
        
        return $this->redirect($this->generateUrl('datoscampanaspoliticas_cantidad', array('id' => $idestructuracampanapolitica)));
    }
    

    /**
     * Creates a form to create a DatosCampanasPoliticas entity.
     *
     * @param DatosCampanasPoliticas $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DatosCampanasPoliticas $entity)
    {
        $form = $this->createForm(new DatosCampanasPoliticasType(), $entity, array(
            'action' => $this->generateUrl('datoscampanaspoliticas_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new DatosCampanasPoliticas entity.
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newAction(Request $request)
    {
        $seg = $this->container->get('victoria_app.vicseguridad');
        
        /* Verifica que el usuario este autenticado */
        $ok = $seg->validarUsuario();
        
        /* Verifica que el usuario tenga acceso a esta ruta o opción */
        $ruta = $request->attributes->get('_route'); 
        $ok = $seg->comprobarAcceso($ruta);
        
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        $entity = new DatosCampanasPoliticas();
        $form   = $this->createCreateForm($entity);

        return $this->render('VictoriaAppBundle:DatosCampanasPoliticas:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'menu' => $menu,
        ));
    }

    /**
     * Finds and displays a DatosCampanasPoliticas entity.
     *
     */
    public function showAction(Request $request, $id)
    {
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosCampanasPoliticas')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosCampanasPoliticas entity.');
        }

        return $this->render('VictoriaAppBundle:DatosCampanasPoliticas:show.html.twig', array(
            'entity'      => $entity,
            'menu' => $menu,
        ));
    }
    
       /**
     * Finds and displays a DatosCampanasPoliticas entity.
     *
     */
    public function verasignacionesAction(Request $request, $id)
    {
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        $em = $this->getDoctrine()->getManager();

        $query = "select 
ca.id_comision, ca.id_persona, 
cc.id_estructura, cc.tipo_estructura,
coalesce(p.nombres,'')||' '||coalesce(p.apellidos,'') nombres,
tc.id_tipo_comision, tc.descripcion
from datos_comisiones_asignadas ca join datos_comisiones_cantidad cc on (ca.id_comision = cc.id_comision)
join datos_personas p on (p.id_persona = ca.id_persona)
join ad_tipos_comision tc on (tc.id_tipo_comision = cc.id_tipo_comision )
where ca.id_comision = :idcom ";
        $stmt = $em->getConnection()->prepare($query);
        $stmt->bindValue('idcom',$id);
        $stmt->execute();
        $entities = $stmt->fetchAll();

        return $this->render('VictoriaAppBundle:DatosCampanasPoliticas:asignaciones.html.twig', array(
            'entities'      => $entities,
            'menu' => $menu,
        ));
    }
    

    /**
     * Finds and displays a DatosCampanasPoliticas entity.
     *
     */
    public function verpersonaAction(Request $request, $id)
    {
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosPersonas')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosCampanasPoliticas entity.');
        }



        return $this->render('VictoriaAppBundle:DatosPersonas:show.html.twig', array(
            'entity'      => $entity,
            'menu' => $menu,
        ));
    }
    

    /**
     * Displays a form to edit an existing DatosCampanasPoliticas entity.
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editAction(Request $request, $id)
    {
        $seg = $this->container->get('victoria_app.vicseguridad');
        
        /* Verifica que el usuario este autenticado */
        $ok = $seg->validarUsuario();
        
        /* Verifica que el usuario tenga acceso a esta ruta o opción */
        $ruta = $request->attributes->get('_route'); 
        $ok = $seg->comprobarAcceso($ruta);
        
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosCampanasPoliticas')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosCampanasPoliticas entity.');
        }

        $editForm = $this->createEditForm($entity);

        return $this->render('VictoriaAppBundle:DatosCampanasPoliticas:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'menu' => $menu,
        ));
    }

    /**
    * Creates a form to edit a DatosCampanasPoliticas entity.
    *
    * @param DatosCampanasPoliticas $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(DatosCampanasPoliticas $entity)
    {
        $form = $this->createForm(new DatosCampanasPoliticasType(), $entity, array(
            'action' => $this->generateUrl('datoscampanaspoliticas_update', array('id' => $entity->getIdCampana())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing DatosCampanasPoliticas entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosCampanasPoliticas')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosCampanasPoliticas entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('datoscampanaspoliticas_edit', array('id' => $id)));
        }

        return $this->render('VictoriaAppBundle:DatosCampanasPoliticas:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a DatosCampanasPoliticas entity.
     *
     */
    public function borrarpersonaAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $query = "delete from datos_comisiones_asignadas
        where id_persona = :idper";
        $stmt = $em->getConnection()->prepare($query);
        $stmt->bindValue('idper',$id);
        $stmt->execute();
        
        return $this->redirect($this->generateUrl('datoscampanaspoliticas'));
    }
    /**
     * Deletes a DatosCampanasPoliticas entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('VictoriaAppBundle:DatosCampanasPoliticas')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DatosCampanasPoliticas entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('datoscampanaspoliticas'));
    }

    /**
     * Creates a form to delete a DatosCampanasPoliticas entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('datoscampanaspoliticas_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
/**
     * Lists all DatosCampanasPoliticas entities.
     *
     */
    public function cantidadAction(Request $request, $id)
    {
        $seg = $this->container->get('victoria_app.vicseguridad');
        
        /* Verifica que el usuario este autenticado */
        $ok = $seg->validarUsuario();
        
        $session = $request->getSession();
        $menu = $session->get('_menu');
        $idUsuario = $session->get('_id_usuario');
        
        /* Obtiene las notificaciones que tiene el usuario */
        $entnot = $seg->obtenerNotificaciones($idUsuario);
        /* Obtiene las tareas que tiene el usuario */
        $enttar = $seg->obtenerTareas($idUsuario);
        
        $em = $this->getDoctrine()->getManager();
        
        /* Obtiene todas las comisiones de la estructura C segun las ingresadas en la tabla tipo_comisiones */
        
        $query = "select tc.id_tipo_comision, tc.descripcion, tc.id_estructura clase_estrucura,
        cc.id_comision, cc.id_estructura, cc.tipo_estructura, cc.cantidad, pa.personasasignadas 
        from ad_tipos_comision tc 
        left join datos_comisiones_cantidad cc on (tc.id_tipo_comision = cc.id_tipo_comision and cc.id_estructura = :idest)
        left join (select id_comision, count(*) personasasignadas
        from datos_comisiones_asignadas
        group by id_comision) pa on (pa.id_comision = cc.id_comision)
        where tc.id_estructura = 1";
        $stmt = $em->getConnection()->prepare($query);
        $stmt->bindValue('idest',$id);
        $stmt->execute();
        $entities = $stmt->fetchAll();
 
        //$entities = $em->getRepository('VictoriaAppBundle:AdTiposComision')->findBy(array('idEstructura' => 1));
        
        return $this->render('VictoriaAppBundle:DatosCampanasPoliticas:cantidad.html.twig', array(
            'entities' => $entities,
            'idcampanapolitica' => $id,
            'menu' => $menu,
            'datosnoti' => $entnot,
            'datostar' => $enttar,
        ));
    }
}

