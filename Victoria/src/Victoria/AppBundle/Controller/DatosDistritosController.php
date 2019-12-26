<?php

namespace Victoria\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Victoria\AppBundle\Entity\DatosDistritos;
use Victoria\AppBundle\Entity\DatosComisionesCantidad;
use Victoria\AppBundle\Entity\DatosComisionesAsignadas;
use Victoria\AppBundle\Form\DatosDistritosType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * DatosDistritos controller.
 *
 */
class DatosDistritosController extends Controller
{

    /**
     * Lists all DatosDistritos entities.
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

        /* Valida si selecciona todos los ditritos para visualizar */
        $strwhere = '';
        $strwhere2 = '';
        $strwhere3 = '';
        
        if($id != 0) {
            //$entities = $em->getRepository('VictoriaAppBundle:DatosDistritos')->findBy(array('idCampana' => $id));
            $strwhere = ' and cp.id_campana = '.$id;
            $strwhere2 = ' where id_campana = '.$id;
            $strwhere3 = ' and id_campana = '.$id;
        } elseif($idCampana == 0 && $idDistrito == 0) {
            //$entities = $em->getRepository('VictoriaAppBundle:DatosDistritos')->findAll();
            $strwhere = '';
        } elseif($idCampana != 0 && $idDistrito == 0) {            
            //$entities = $em->getRepository('VictoriaAppBundle:DatosDistritos')->findBy(array('idCampana' => $idCampana));
            $strwhere = ' and cp.id_campana = '.$idCampana;
            $strwhere2 = ' where id_campana = '.$idCampana;
            $strwhere3 = ' and id_campana = '.$idCampana;
        } else {
            //$entities = $em->getRepository('VictoriaAppBundle:DatosDistritos')->findBy(array('idCampana' => $idCampana, 'idDistrito' => $idDistrito )); 
            $strwhere = ' and cp.id_campana = '.$idCampana.' and cp.id_distrito = '.$idDistrito;
            $strwhere2 = ' where id_campana = '.$idCampana.' and cp.id_distrito = '.$idDistrito;
            $strwhere3 = ' and id_campana = '.$idCampana.' and cp.id_distrito = '.$idDistrito;
        }
        
        $query = "select cp.id_distrito, cp.id_campana, cp.nombre, ccp.total_campanas, acp.total_asignadas, vot.votantes, ce.carga 
from datos_distritos cp
left join (
	select id_estructura, sum(cantidad) total_campanas
	from datos_comisiones_cantidad
	where tipo_estructura = 2
	group by id_estructura
) ccp on (cp.id_distrito = ccp.id_estructura)
left join (
	select id_estructura, count(*) total_asignadas 
	from datos_comisiones_cantidad cc join datos_comisiones_asignadas ca on (cc.id_comision = ca.id_comision)
	where cc.tipo_estructura = 2
	group by id_estructura
) acp on (cp.id_distrito = acp.id_estructura)
left join (
	select cv.id_distrito, count(*) votantes
	from datos_votantes dv join datos_centros_votacion cv on (cv.id_cv = dv.id_cv ) 
	%2\$s --where id_campana = :idcmp
	group by id_distrito
) vot on (vot.id_distrito = cp.id_distrito)
left join (
	select id_distrito, sum(cargar_electoral) carga
	from datos_centros_votacion
	where id_campana <> 0 %3\$s --and id_campana = :idcmp 
	group by id_distrito
) ce on (ce.id_distrito = cp.id_distrito)
where cp.id_distrito <> 0 %1\$s";
        $query = sprintf($query, $strwhere, $strwhere2, $strwhere3);
        $stmt = $em->getConnection()->prepare($query);
        //$stmt->bindValue('idcmp',$idCampana);
        $stmt->execute();
        $entities = $stmt->fetchAll(); 
        
        return $this->render('VictoriaAppBundle:DatosDistritos:index.html.twig', array(
            'entities' => $entities,
            'menu' => $menu,
            'datosnoti' => $entnot,
            'datostar' => $enttar,
        ));
    }
    /**
     * Creates a new DatosDistritos entity.
     *
     */
    public function createAction(Request $request)
    {
        $session = $request->getSession();
        $idCampana = $session->get('_id_campana');
        
        $entity = new DatosDistritos();
        $form = $this->createCreateForm($entity, $idCampana);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('datosdistritos_show', array('id' => $entity->getIdDistrito())));
        }

        return $this->render('VictoriaAppBundle:DatosDistritos:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }
    
       public function createcantAction(Request $request)
    {
        $session = $request->getSession();
        $idCampana = $session->get('_id_campana');
        $idUsuario = $session->get('_id_usuario');
        $menu = $session->get('_menu');
                
        $em = $this->getDoctrine()->getManager();
        
        /* Obtiene la cantidad de comisiones para la estructura C */
        $query = "select * from ad_tipos_comision where id_estructura = 2";
        $stmt = $em->getConnection()->prepare($query);
        $stmt->execute();
        $entcantcomi = $stmt->fetchAll();
        
        if (!$entcantcomi) {
            throw $this->createNotFoundException('No se encontro datos en la cantidad de comisiones por Distrito.');
        }
        
        $idestructura_distritos = $request->get('idestructura');
        /* Obtendo los datos del request para guardalos en la entidad */
        foreach( $entcantcomi as $comi) {
            /* Comprobar si la comision existe o es nueva 
             * si existe actualizo los datos
             * en caso contrario creo una nueva entidad
             * Nota: se crearan todas las comisiones para cada Distrito si no tiene
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
                $entity->setIdEstructura($idestructura_distritos);
                $entity->setIdTipoComision($idtipocomision);
                $entity->setTipoEstructura(2); // 3 = Centro de votacion, 2 = Distritos , 1 = Campañas
                
                $em->persist($entity);
            } else {
                $entity = $em->getRepository('VictoriaAppBundle:DatosComisionesCantidad')->find($idcomision);
                
                if (!$entity) {
                    throw $this->createNotFoundException('No se encontro datos en la cantidad de comisiones por Distrito. para editar');
                }
                $entity->setCantidad($cantidad);
                $em->flush();
            }
        }
            
        $em->flush();
        
        return $this->redirect($this->generateUrl('datosdistritos_cantidad', array('id' => $idestructura_distritos)));
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
        $idestructuradistritos = $request->get('idestructuradistritos');

        $entity = new DatosComisionesAsignadas();

        $entity->setIdPersona($idpersona);
        $entity->setIdComision($idcomision);    
        $em->persist($entity);
        $em->flush();
        
        return $this->redirect($this->generateUrl('datosdistritos_cantidad', array('id' => $idestructuradistritos)));
    }
    

    /**
     * Creates a form to create a DatosDistritos entity.
     *
     * @param DatosDistritos $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DatosDistritos $entity, $idCampana)
    {
        $form = $this->createForm(new DatosDistritosType(), $entity, array(
            'action' => $this->generateUrl('datosdistritos_create'),
            'method' => 'POST',
            'label' => $idCampana,
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new DatosDistritos entity.
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
        
        $entity = new DatosDistritos();
        $form   = $this->createCreateForm($entity, $idCampana);

        return $this->render('VictoriaAppBundle:DatosDistritos:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'menu' => $menu,
        ));
    }

    /**
     * Finds and displays a DatosDistritos entity.
     *
     */
    public function showAction(Request $request, $id)
    {
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosDistritos')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosDistritos entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VictoriaAppBundle:DatosDistritos:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
             'menu' => $menu,
        ));
    }
    
        /**
     * Finds and displays a DatosDistritos entity.
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

        return $this->render('VictoriaAppBundle:DatosDistritos:asignaciones.html.twig', array(
            'entities'      => $entities,
            'menu' => $menu,
        ));
    }
    

    /**
     * Finds and displays a DatosDistritos entity.
     *
     */
    public function verpersonaAction(Request $request, $id)
    {
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosPersonas')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosDistritos entity.');
        }



        return $this->render('VictoriaAppBundle:DatosPersonas:show.html.twig', array(
            'entity'      => $entity,
            'menu' => $menu,
        ));
    }
    

    /**
     * Displays a form to edit an existing DatosDistritos entity.
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

        $entity = $em->getRepository('VictoriaAppBundle:DatosDistritos')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosDistritos entity.');
        }

        $editForm = $this->createEditForm($entity, $idCampana);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VictoriaAppBundle:DatosDistritos:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'menu' => $menu,
        ));
    }

    /**
    * Creates a form to edit a DatosDistritos entity.
    *
    * @param DatosDistritos $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(DatosDistritos $entity, $idCampana)
    {
        $form = $this->createForm(new DatosDistritosType(), $entity, array(
            'action' => $this->generateUrl('datosdistritos_update', array('id' => $entity->getIdDistrito())),
            'method' => 'PUT',
            'label' => $idCampana,
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing DatosDistritos entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $session = $request->getSession();
        $idCampana = $session->get('_id_campana');
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosDistritos')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosDistritos entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity, $idCampana);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('datosdistritos_edit', array('id' => $id)));
        }

        return $this->render('VictoriaAppBundle:DatosDistritos:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a DatosDistritos entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('VictoriaAppBundle:DatosDistritos')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DatosDistritos entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('datosdistritos'));
    }

     /**
     * Deletes a DatosDistritos entity.
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
        
        return $this->redirect($this->generateUrl('datosdistritos'));
    }
    
    /**
     * Creates a form to delete a DatosDistritos entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('datosdistritos_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    
     /**
     * Lists all DatosDistritos entities.
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
        
        $query = "  select tc.id_tipo_comision, tc.descripcion, tc.id_estructura clase_estrucura,
                    cc.id_comision, cc.id_estructura, cc.tipo_estructura, cc.cantidad, pa.personasasignadas 
                    from ad_tipos_comision tc 
                    left join datos_comisiones_cantidad cc on (tc.id_tipo_comision = cc.id_tipo_comision and cc.id_estructura = :idest)
                    left join (select id_comision, count(*) personasasignadas
                    from datos_comisiones_asignadas
                    group by id_comision) pa on (pa.id_comision = cc.id_comision)
                    where tc.id_estructura = 2";
        $stmt = $em->getConnection()->prepare($query);
        $stmt->bindValue('idest',$id);
        $stmt->execute();
        $entities = $stmt->fetchAll();
 
        //$entities = $em->getRepository('VictoriaAppBundle:AdTiposComision')->findBy(array('idEstructura' => 3));
        
        return $this->render('VictoriaAppBundle:DatosDistritos:cantidad.html.twig', array(
            'entities' => $entities,
            'iddistritos' => $id,
            'menu' => $menu,
            'datosnoti' => $entnot,
            'datostar' => $enttar,
        ));
    }
}

