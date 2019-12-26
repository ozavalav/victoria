<?php

namespace Victoria\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Victoria\AppBundle\Entity\DatosCentrosVotacion;
use Victoria\AppBundle\Entity\DatosComisionesCantidad;
use Victoria\AppBundle\Entity\DatosComisionesAsignadas;
use Victoria\AppBundle\Form\DatosCentrosVotacionType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * DatosCentrosVotacion controller.
 *
 */
class DatosCentrosVotacionController extends Controller
{

    /**
     * Lists all DatosCentrosVotacion entities.
     *
     */
    public function indexAction(Request $request, $id = 0)
    {
        $seg = $this->container->get('victoria_app.vicseguridad');
        
        /* Verifica que el usuario este autenticado */
        $ok = $seg->validarUsuario();
        
        /* Verifica que el usuario tenga acceso a esta ruta o opción */
        $ruta = $request->attributes->get('_route'); 
        $ok = $seg->comprobarAcceso($ruta);
        
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
        
        /* Valida el nivel de acceso para ver todos los CV o solamente los que tiene acceso */
        
        /*if($id != 0) {
            $entities = $em->getRepository('VictoriaAppBundle:DatosCentrosVotacion')->findBy(array('idDistrito' => $id));
        } elseif($idCampana == 0 && $idDistrito == 0) {
            $entities = $em->getRepository('VictoriaAppBundle:DatosCentrosVotacion')->findAll();
        } elseif($idCampana != 0 && $idDistrito == 0) {
            $entities = $em->getRepository('VictoriaAppBundle:DatosCentrosVotacion')->findBy(array('idCampana' => $idCampana));
        } else {
            $entities = $em->getRepository('VictoriaAppBundle:DatosCentrosVotacion')->findBy(array('idCampana' => $idCampana, 'idDistrito' => $idDistrito )); 
        }*/
        
        if($id != 0) {
            $strwhere = ' and cv.id_campana = '.$id;
        } elseif($idCampana == 0 && $idDistrito == 0) {
            $strwhere = '';
        } elseif($idCampana != 0 && $idDistrito == 0) {
            $strwhere = ' and cv.id_campana = '.$idCampana;
        } else {            
            $strwhere = ' and cv.id_campana = '.$idCampana.' and cv.id_distrito = '.$idDistrito;
        }
        
        $query = "select cv.id_cv, cv.tipo_cv, cv.nombre, cv.cargar_electoral, ccv.total_cv, acv.total_asignadas, vot.votantes  
from datos_centros_votacion cv
left join (
	select id_estructura, sum(cantidad) total_cv
	from datos_comisiones_cantidad
	where tipo_estructura = 3
	group by id_estructura
) ccv on (cv.id_cv = ccv.id_estructura)
left join (
	select id_estructura, count(*) total_asignadas 
	from datos_comisiones_cantidad cc join datos_comisiones_asignadas ca on (cc.id_comision = ca.id_comision)
	where cc.tipo_estructura = 3
	group by id_estructura
) acv on (cv.id_cv = acv.id_estructura)
left join (
	select id_cv, count(*) votantes from datos_votantes group by id_cv
) vot on (vot.id_cv = acv.id_estructura) 
where cv.id_cv <> 0 %1\$s";
        $query = sprintf($query, $strwhere);
        $stmt = $em->getConnection()->prepare($query);
        $stmt->execute();
        $entities = $stmt->fetchAll();         
        
        return $this->render('VictoriaAppBundle:DatosCentrosVotacion:index.html.twig', array(
            'entities' => $entities,
            'menu' => $menu,
            'datosnoti' => $entnot,
            'datostar' => $enttar,
        ));
    }
    /**
     * Creates a new DatosCentrosVotacion entity.
     *
     */
    public function createAction(Request $request)
    {
        $session = $request->getSession();
        $idCampana = $session->get('_id_campana');
        $menu = $session->get('_menu');
        
        $entity = new DatosCentrosVotacion();
        $form = $this->createCreateForm($entity, $idCampana);
        $form->handleRequest($request);
        
        $em = $this->getDoctrine()->getManager();
        $idDis = $request->get('victoria_appbundle_datoscentrosvotacion')['idDistrito'];
        $entdis = $em->getRepository('VictoriaAppBundle:DatosDistritos')->findBy(array('idDistrito' => $idDis));
        $entity->setIdDistrito($entdis[0]);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('datoscentrosvotacion_show', array('id' => $entity->getIdcv())));
        }

        return $this->render('VictoriaAppBundle:DatosCentrosVotacion:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'menu' => $menu,
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
        $query = "select * from ad_tipos_comision where id_estructura = 3";
        $stmt = $em->getConnection()->prepare($query);
        $stmt->execute();
        $entcantcomi = $stmt->fetchAll();
        
        if (!$entcantcomi) {
            throw $this->createNotFoundException('No se encontro datos en la cantidad de comisiones por CV.');
        }
        
        $idestructura_cv = $request->get('idestructura');
        /* Obtendo los datos del request para guardalos en la entidad */
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
                $entity->setIdEstructura($idestructura_cv);
                $entity->setIdTipoComision($idtipocomision);
                $entity->setTipoEstructura(3); // 3 = Centro de votacion, 2 = Distritos , 1 = Campañas
                
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
        
        return $this->redirect($this->generateUrl('datoscentrosvotacion_cantidad', array('id' => $idestructura_cv)));
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
        $idestructuracv = $request->get('idestructuracv');

        $entity = new DatosComisionesAsignadas();

        $entity->setIdPersona($idpersona);
        $entity->setIdComision($idcomision);    
        $em->persist($entity);
        $em->flush();
        
        return $this->redirect($this->generateUrl('datoscentrosvotacion_cantidad', array('id' => $idestructuracv)));
    }
    
    /**
     * Creates a form to create a DatosCentrosVotacion entity.
     *
     * @param DatosCentrosVotacion $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DatosCentrosVotacion $entity, $idCampana)
    {
        $form = $this->createForm(new DatosCentrosVotacionType(), $entity, array(
            'action' => $this->generateUrl('datoscentrosvotacion_create'),
            'method' => 'POST',
            'label' => $idCampana,
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new DatosCentrosVotacion entity.
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
        $idCampana = $session->get('_id_campana');
        
        $entity = new DatosCentrosVotacion();
        $form   = $this->createCreateForm($entity, $idCampana);

        return $this->render('VictoriaAppBundle:DatosCentrosVotacion:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'menu' => $menu,
        ));
    }

    /**
     * Finds and displays a DatosCentrosVotacion entity.
     *
     */
    public function showAction(Request $request, $id)
    {
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosCentrosVotacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosCentrosVotacion entity.');
        }



        return $this->render('VictoriaAppBundle:DatosCentrosVotacion:show.html.twig', array(
            'entity'      => $entity,
            'menu' => $menu,
        ));
    }
    
    /**
     * Finds and displays a DatosCentrosVotacion entity.
     *
     */
    public function verasignacionesAction(Request $request, $id, $porcv = 0)
    {
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        $em = $this->getDoctrine()->getManager();

        if ($porcv == 1 ) {
            $query = "select
coalesce(dp.id_persona,0) id_persona,tc.descripcion, coalesce(dp.nombres,'no') ||' '|| coalesce(dp.apellidos,'asignado') nombres
from 
datos_comisiones_cantidad cc 
left join datos_comisiones_asignadas ca on (ca.id_comision = cc.id_comision)
left join ad_tipos_comision tc on ( tc.id_tipo_comision = cc.id_tipo_comision )
left join datos_personas dp on (dp.id_persona = ca.id_persona)
where cc.tipo_estructura = 3 and cc.id_estructura = :idcom order by 2";
            
        } else {
        $query = "select 
ca.id_comision, ca.id_persona, 
cc.id_estructura, cc.tipo_estructura,
coalesce(p.nombres,'')||' '||coalesce(p.apellidos,'') nombres,
tc.id_tipo_comision, tc.descripcion
from datos_comisiones_asignadas ca join datos_comisiones_cantidad cc on (ca.id_comision = cc.id_comision)
join datos_personas p on (p.id_persona = ca.id_persona)
join ad_tipos_comision tc on (tc.id_tipo_comision = cc.id_tipo_comision )
where ca.id_comision = :idcom ";
        }
        $stmt = $em->getConnection()->prepare($query);
        $stmt->bindValue('idcom',$id);
        $stmt->execute();
        $entities = $stmt->fetchAll();

        return $this->render('VictoriaAppBundle:DatosCentrosVotacion:asignaciones.html.twig', array(
            'entities'      => $entities,
            'menu' => $menu,
        ));
    }
    

    /**
     * Finds and displays a DatosCentrosVotacion entity.
     *
     */
    public function verpersonaAction(Request $request, $id)
    {
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosPersonas')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosCentrosVotacion entity.');
        }



        return $this->render('VictoriaAppBundle:DatosPersonas:show.html.twig', array(
            'entity'      => $entity,
            'menu' => $menu,
        ));
    }
    
    /**
     * Displays a form to edit an existing DatosCentrosVotacion entity.
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
        $idCampana = $session->get('_id_campana');
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosCentrosVotacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosCentrosVotacion entity.');
        }

        $editForm = $this->createEditForm($entity, $idCampana);

        return $this->render('VictoriaAppBundle:DatosCentrosVotacion:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'menu' => $menu,
        ));
    }

    /**
    * Creates a form to edit a DatosCentrosVotacion entity.
    *
    * @param DatosCentrosVotacion $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(DatosCentrosVotacion $entity, $idCampana)
    {
        $form = $this->createForm(new DatosCentrosVotacionType(), $entity, array(
            'action' => $this->generateUrl('datoscentrosvotacion_update', array('id' => $entity->getIdCv())),
            'method' => 'PUT',
            'label' => $idCampana,
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing DatosCentrosVotacion entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $session = $request->getSession();
        $idCampana = $session->get('_id_campana');
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosCentrosVotacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosCentrosVotacion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity, $idCampana);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('datoscentrosvotacion_edit', array('id' => $id)));
        }

        return $this->render('VictoriaAppBundle:DatosCentrosVotacion:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a DatosCentrosVotacion entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('VictoriaAppBundle:DatosCentrosVotacion')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DatosCentrosVotacion entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('datoscentrosvotacion'));
    }
    
    /**
     * Deletes a DatosCentrosVotacion entity.
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
        
        return $this->redirect($this->generateUrl('datoscentrosvotacion'));
    }

    /**
     * Creates a form to delete a DatosCentrosVotacion entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('datoscentrosvotacion_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    /**
     * Lists all DatosCentrosVotacion entities.
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
where tc.id_estructura = 3";
        $stmt = $em->getConnection()->prepare($query);
        $stmt->bindValue('idest',$id);
        $stmt->execute();
        $entities = $stmt->fetchAll();
 
        //$entities = $em->getRepository('VictoriaAppBundle:AdTiposComision')->findBy(array('idEstructura' => 3));
        
        return $this->render('VictoriaAppBundle:DatosCentrosVotacion:cantidad.html.twig', array(
            'entities' => $entities,
            'idcv' => $id,
            'menu' => $menu,
            'datosnoti' => $entnot,
            'datostar' => $enttar,
        ));
    }
}
