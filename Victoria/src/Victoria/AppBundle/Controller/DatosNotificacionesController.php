<?php

namespace Victoria\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Victoria\AppBundle\Entity\DatosNotificaciones;
use Victoria\AppBundle\Form\DatosNotificacionesType;

/**
 * DatosNotificaciones controller.
 *
 */
class DatosNotificacionesController extends Controller
{

    /**
     * Lists all DatosNotificaciones entities.
     *
     */
    public function indexAction(Request $request)
    {
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        $em = $this->getDoctrine()->getManager();

        //$entities = $em->getRepository('VictoriaAppBundle:DatosNotificaciones')->findAll();
        /* Se buscan todos los usuarios que cumplan con los parametros de 
        * Campaña y Distrito para enviar el mensaje a ellos.
        */
        $query = "select
        row_number() over() orden,  
        n.numero_mensaje numero,
        c.nombre campana, 
        d.nombre distrito, 
        count(*) total, 
        sum(case when estado = 1 then 1 else 0 end) enviados,
        sum(case when estado = 2 then 1 else 0 end) recibidos,
        sum(case when estado = 3 then 1 else 0 end) eliminados
        from datos_notificaciones n join datos_campanas_politicas c on (n.id_campana = c.id_campana)
        join datos_distritos d on (d.id_distrito = n.id_distrito)
        group by c.nombre, d.nombre, n.numero_mensaje";
        //$query = sprintf($query, $codColg, $rngfechag);
        $stmt = $em->getConnection()->prepare($query);
        //$stmt->bindValue('campana',$idCampana);
        //$stmt->bindValue('distrito',$idDistrito);
        $stmt->execute();
        $entities = $stmt->fetchAll();

        return $this->render('VictoriaAppBundle:DatosNotificaciones:index.html.twig', array(
            'entities' => $entities,
            'menu' => $menu,
        ));
    }
    /**
     * Creates a new DatosNotificaciones entity.
     *
     */
    public function createAction(Request $request)
    {
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        $entity = new DatosNotificaciones();
        $form = $this->createCreateForm($entity);
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
             */
            $query = "select id from ad_user where id_campana = :campana and id_distrito = :distrito ";
            //$query = sprintf($query, $codColg, $rngfechag);
            $stmt = $em->getConnection()->prepare($query);
            $stmt->bindValue('campana',$idCampana);
            $stmt->bindValue('distrito',$idDistrito);
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
    private function createCreateForm(DatosNotificaciones $entity)
    {
        $form = $this->createForm(new DatosNotificacionesType(), $entity, array(
            'action' => $this->generateUrl('datosnotificaciones_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new DatosNotificaciones entity.
     *
     */
    public function newAction(Request $request)
    {
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        $entity = new DatosNotificaciones();
        $form   = $this->createCreateForm($entity);

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
     *
     */
    public function editAction(Request $request, $id)
    {
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
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        ///if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $entity = $em->getRepository('VictoriaAppBundle:DatosNotificaciones')->findBy(array('numeroMensaje' => $id));
            
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DatosNotificaciones entity.');
            }
            
            foreach ($entity as $ent) {
                $em->remove($ent);
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
