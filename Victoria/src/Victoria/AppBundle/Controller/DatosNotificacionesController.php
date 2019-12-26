<?php

namespace Victoria\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

use Victoria\AppBundle\Entity\DatosNotificaciones;
use Victoria\AppBundle\Form\DatosNotificacionesType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * DatosNotificaciones controller.
 *
 */
class DatosNotificacionesController extends Controller
{
    /* Metodo:
     * Para cambiar el estado de la notificación segun el valor pasado en el Ajax
     * 2 = Recibido
     */
    public function cambioestadoAction($param){
        $parametros = explode("&&", $param);
        $idNot= $parametros[0];
        $nestado= $parametros[1];

        $response = new JsonResponse();
        $em = $this->getDoctrine()->getManager();
        
        $entity = $em->getRepository('VictoriaAppBundle:DatosNotificaciones')->find($idNot);
        
        if (!$entity) {
            throw $this->createNotFoundException('VICTORIA: No se pudo encontrar el ID del mensaje.');
        }
        
        /* *** Procecso que se tiene que hacer cuando se habilite el control de cambios ****
        $usr= $this->get('security.context')->getToken()->getUser();
        $strgUsuario = $usr->getUsername();        
        $s = date('Y-m-d H:i:s');           

        
        $entity->setIsActive(false);
        $entity->setUsuarioUltimaModificacion($strgUsuario);
        $entity->setFechaUltimaModificacion(new \DateTime($s));
        */
        $entity->setEstado($nestado);
        $em->flush();
        
        if (!$entity) {
            $response->setData(array('message' => 'false','razon' => 'VICTORIA: Hubo un error al hacer el cambio'));
        } else {
          $response->setData(array('message' => 'true'));  
        }
        return $response;
    }
    
    /**
     * Lists all DatosNotificaciones entities.
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
        
        $session = $request->getSession();
        $menu = $session->get('_menu');
        $idcampana = $session->get('_id_campana');
        $iddistrito = $session->get('_id_distrito');
        $idusuario = $session->get('_id_usuario');
        $seg = $this->container->get('victoria_app.vicseguridad');
        
        /* Obtiene las notificaciones que tiene el usuario */
        $entnot = $seg->obtenerNotificaciones($idusuario);
        /* Obtiene las tareas que tiene el usuario */
        $enttar = $seg->obtenerTareas($idusuario);
        
        $em = $this->getDoctrine()->getManager();
        
        /* Se define que información va a filtar segun el nivel de campana y distrito que tiene asignado*/
        $strWhere = $seg->filtrarConsulta($idcampana, $iddistrito);
        
        /* Filtro las notificacion por usuario
         * Si tiene acceso a todas las campañas y distritos, de depliegan todos los mensajes
         * caso contrario solo se muestra las notificaciones del usuario y distrito
         */
        $strgrupo = ''; //desagrupo la consulta segun el nivel del usuario
        if ($idcampana != 0 && $iddistrito != 0) {
            $strWhere = ' where id_usuario = ' . $idusuario;
            $strgrupo = 'p.id_notificacion, '; //agrupo la consulta por id_notificacion
        }
        /* Filtro las notificaciónes por estado
         * Estado = 1 para los usuarios de niveles bajos
         * Estado = 1,2,3 para los usuarios de estado alto 
         */
        
        if($strWhere == '') {
            $strWhere = $strWhere . ' where p.estado in (1,2,3) ';
        } else {
            $strWhere = $strWhere . ' and p.estado in (1,2)';
        }
        //$entities = $em->getRepository('VictoriaAppBundle:DatosNotificaciones')->findAll();
        /* Se buscan todos los usuarios que cumplan con los parametros de 
        * Campaña y Distrito para enviar el mensaje a ellos.
        */
        $query = "select
        row_number() over() orden, %2\$s
        p.numero_mensaje numero,
        c.nombre campana, 
        d.nombre distrito, 
        count(*) total, 
        sum(case when estado = 1 then 1 else 0 end) enviados,
        sum(case when estado = 2 then 1 else 0 end) recibidos,
        sum(case when estado = 3 then 1 else 0 end) eliminados
        from datos_notificaciones p join datos_campanas_politicas c on (p.id_campana = c.id_campana) 
        join datos_distritos d on (d.id_distrito = p.id_distrito) %1\$s
        group by %2\$s c.nombre, d.nombre, p.numero_mensaje";
        $query = sprintf($query, $strWhere, $strgrupo);
        $stmt = $em->getConnection()->prepare($query);
        //$stmt->bindValue('campana',$idCampana);
        //$stmt->bindValue('distrito',$idDistrito);
        $stmt->execute();
        $entities = $stmt->fetchAll();

        return $this->render('VictoriaAppBundle:DatosNotificaciones:index.html.twig', array(
            'entities' => $entities,
            'menu' => $menu,
            'datosnoti' => $entnot, 
            'datostar' => $enttar, 
        ));
    }
    /**
     * Creates a new DatosNotificaciones entity.
     *
     */
    public function createAction(Request $request)
    {
        $seg = $this->container->get('victoria_app.vicseguridad');
        
        $session = $request->getSession();
        $menu = $session->get('_menu');
        $usuario = $session->get('_nombre_usuario'); //Usuario quien pone la notificación
        $idCampana = $session->get('_id_campana');
        
        $entity = new DatosNotificaciones();
        $form = $this->createCreateForm($entity, $idCampana);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            /* Obtiene los datos ingresados del request*/
            $idCampana = $entity->getIdCampana()->getIdCampana();
            $idDistrito = $entity->getIdDistrito()->getIdDistrito();
            $mensaje = $entity->getMensaje();
            
            /* Obtiene la fecha y hora del sistema */
            $fecha = new \DateTime("now");
            
            
            /* Se buscan todos los usuarios que cumplan con los parametros de 
             * Campaña y Distrito para enviar el mensaje a ellos.
             * Dependiendo de la campaña y distritro solecionados se entregaran los mensajes
             * Campaña = 0 y Distrito = 0 (se envia el mensaje a todos los usuarios )
             */
            
            /* Se define que información va a filtar segun el nivel de campana y distrito que tiene asignado*/
            $strWhere = $seg->filtrarConsulta($idCampana, $idDistrito);
            
            $query = "select id from ad_user p %1\$s";
            $query = sprintf($query, $strWhere);
            $stmt = $em->getConnection()->prepare($query);
            //$stmt->bindValue('campana',$idCampana);
            $stmt->execute();
            $datosusr = $stmt->fetchAll();
            
            /* Generar el numero de secuencia para el numero de mensaje
             * este es un numero unico para todos los usuarios que reciben el mensaje 
             */
            try {
                $sequenceName = 'datos_notificaciones_numero_mensaje_seq';
                $dbConnection = $em->getConnection();
                $nextvalQuery = $dbConnection->getDatabasePlatform()->getSequenceNextValSQL($sequenceName);
                $nummsg = (int)$dbConnection->fetchColumn($nextvalQuery);

            } catch (\Exception $e) {
                $this->addFlash('error', $e->getMessage());
            }
                
            /* Graba los mensajes en la tabla uno por cada usuario encontrado */
            foreach($datosusr as $usr) {
                $usrent = new DatosNotificaciones();
                
                $usrent->setIdCampana($entity->getIdCampana());
                $usrent->setIdDistrito($entity->getIdDistrito());
                
                /*Busca el usuario para agregarlo a la entidad de Notificaciones */
                $etusr = $em->getRepository('VictoriaAppBundle:AdUser')->find($usr["id"]);
                
                $usrent->setNumeroMensaje($nummsg); 
                $usrent->setIdUsuario($etusr);
                $usrent->setMensaje($mensaje);
                $usrent->setFechaEnviado($fecha);
                $usrent->setEstado(1); // 1= Enviando; 2=Recibido; 3=Eliminado
                $usrent->setUsuario($usuario);
                $em->persist($usrent);
                
            }
            $em->flush();

            return $this->redirect($this->generateUrl('datosnotificaciones'));
        }

        return $this->render('VictoriaAppBundle:DatosNotificaciones:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'menu' => $menu,
        ));
    }

    /**
     * Creates a form to create a DatosNotificaciones entity.
     *
     * @param DatosNotificaciones $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DatosNotificaciones $entity, $idCampana)
    {
        $form = $this->createForm(new DatosNotificacionesType(), $entity, array(
            'action' => $this->generateUrl('datosnotificaciones_create'),
            'method' => 'POST',
            'attr' => array('campana' => $idCampana),
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new DatosNotificaciones entity.
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
        
        $entity = new DatosNotificaciones();
        $form   = $this->createCreateForm($entity, $idCampana);

        return $this->render('VictoriaAppBundle:DatosNotificaciones:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'menu' => $menu,
        ));
    }

    /**
     * Finds and displays a DatosNotificaciones entity.
     *
     */
    public function showAction(Request $request, $id)
    {
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosNotificaciones')->findOneBy(array('numeroMensaje' => $id));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosNotificaciones entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VictoriaAppBundle:DatosNotificaciones:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'menu' => $menu,
        ));
    }

    /**
     * Displays a form to edit an existing DatosNotificaciones entity.
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

        $entity = $em->getRepository('VictoriaAppBundle:DatosNotificaciones')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosNotificaciones entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VictoriaAppBundle:DatosNotificaciones:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'menu' => $menu,
        ));
    }

    /**
    * Creates a form to edit a DatosNotificaciones entity.
    *
    * @param DatosNotificaciones $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(DatosNotificaciones $entity)
    {
        $form = $this->createForm(new DatosNotificacionesType(), $entity, array(
            'action' => $this->generateUrl('datosnotificaciones_update', array('id' => $entity->getIdNotificacion())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing DatosNotificaciones entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosNotificaciones')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosNotificaciones entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('datosnotificaciones_edit', array('id' => $id)));
        }

        return $this->render('VictoriaAppBundle:DatosNotificaciones:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a DatosNotificaciones entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $session = $request->getSession();
        $idcampana = $session->get('_id_campana');
        $iddistrito = $session->get('_id_distrito');
        $usuario = $session->get('_id_usuario');
        
        $seg = $this->container->get('victoria_app.vicseguridad');
        /* Verifica que el usuario este autenticado */
        $ok = $seg->validarUsuario();
        
        /* Verifica que el usuario tenga acceso a esta ruta o opción */
        $ruta = $request->attributes->get('_route'); 
        $ok = $seg->comprobarAcceso($ruta);
        
        $em = $this->getDoctrine()->getManager();
        
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        
        ///if ($form->isValid()) {
        
        /* Valido si el usuario tiene acceso completo (campaña = 0 y distrito = 0) 
         * entonces puede borrar todos los mensajes de los contrario solo los mensajes que 
         * le pertenecen.
         */
            if ($idcampana == 0 && $iddistrito == 0) {
                $entity = $em->getRepository('VictoriaAppBundle:DatosNotificaciones')->findBy(array('numeroMensaje' => $id));
            } elseif ($idcampana != 0 && $iddistrito == 0) {
                $entity = $em->getRepository('VictoriaAppBundle:DatosNotificaciones')->findBy(array('numeroMensaje' => $id, 'idCampana' => $idcampana));
            } else {
                $entity = $em->getRepository('VictoriaAppBundle:DatosNotificaciones')->findBy(array('numeroMensaje' => $id, 'idUsuario'=> $usuario));
            }
            
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DatosNotificaciones entity.');
            }
            
            foreach ($entity as $ent) {
                $ent->setEstado(3); //Estado eliminado = 3
                //$em->remove($ent);
            }
            
            $em->flush();
        //}

        return $this->redirect($this->generateUrl('datosnotificaciones'));
    }

    /**
     * Creates a form to delete a DatosNotificaciones entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('datosnotificaciones_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
