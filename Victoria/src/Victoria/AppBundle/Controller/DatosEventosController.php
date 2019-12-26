<?php

namespace Victoria\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Victoria\AppBundle\Entity\DatosEventos;
use Victoria\AppBundle\Form\DatosEventosType;

/**
 * DatosEventos controller.
 *
 */
class DatosEventosController extends Controller
{

    /**
     * Lists all DatosEventos entities.
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

        $idCampana = $session->get('_id_campana');
        $idDistrito = $session->get('_id_distrito');
        $idUsuario = $session->get('_id_usuario');
        
        
        /* Obtiene las notificaciones que tiene el usuario */
        $entnot = $seg->obtenerNotificaciones($idUsuario);
        $usr= $this->get('security.context')->getToken()->getUser();
        $usuario = $usr->getUsername();
        
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('VictoriaAppBundle:DatosEventos')->findBy(array('usuarioCreacion' => $usuario));
        
        $entity = new DatosEventos();
        $form   = $this->createCreateForm($entity);

        return $this->render('VictoriaAppBundle:DatosEventos:index.html.twig', array(
            'entities' => $entities,
            'form'   => $form->createView(),
            'menu' => $menu,
            'datosnoti' => $entnot,
        ));
    }
    /**
     * Creates a new DatosEventos entity.
     *
     */

    
    public function createAction(Request $request)
    {
        $entity = new DatosEventos();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $usr= $this->get('security.context')->getToken()->getUser();
            $usuario = $usr->getUsername();
            $fecha = new \DateTime("now");
            $entity->setUsuarioCreacion($usuario);
            $entity->setUsuarioUltimaModificacion($usuario);
            $entity->setFechaCreacion($fecha);
            $entity->setFechaUltimaModificacion($fecha);
            
            $fechatmp = $entity->getFechaInicio();            
            $fecha = new \DateTime($fechatmp);
            $entity->setFechaInicio($fecha);
            
            $fechatmp = $entity->getFechaFinal();            
            $fecha = new \DateTime($fechatmp);
            $entity->setFechaFinal($fecha);
            
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('datoseventos'));
        }

        return $this->render('VictoriaAppBundle:DatosEventos:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a DatosEventos entity.
     *
     * @param DatosEventos $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DatosEventos $entity)
    {
        $form = $this->createForm(new DatosEventosType(), $entity, array(
            'action' => $this->generateUrl('datoseventos_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new DatosEventos entity.
     *
     */
    public function newAction(Request $request)
    {

        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        $entity = new DatosEventos();
        $form   = $this->createCreateForm($entity);

        return $this->render('VictoriaAppBundle:DatosEventos:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'menu' => $menu,
        ));
    }

    /**
     * Finds and displays a DatosEventos entity.
     *
     */
    public function showAction(Request $request, $id)
    {

        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosEventos')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosEventos entity.');
        }


        return $this->render('VictoriaAppBundle:DatosEventos:show.html.twig', array(
            'entity'      => $entity,
            'menu' => $menu,
        ));
    }

    /**
     * Displays a form to edit an existing DatosEventos entity.
     *
     */
    public function editAction(Request $request, $id)
    {

        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosEventos')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosEventos entity.');
        }
        
        $entity->setFechaInicio($entity->getFechaInicio()->format('m/d/Y H:i:s'));
        $entity->setFechaFinal($entity->getFechaFinal()->format('m/d/Y H:i:s'));
        
        $editForm = $this->createEditForm($entity); 
                
        return $this->render('VictoriaAppBundle:DatosEventos:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'menu' => $menu,
        ));
    }

    /**
    * Creates a form to edit a DatosEventos entity.
    *
    * @param DatosEventos $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(DatosEventos $entity)
    {
        $form = $this->createForm(new DatosEventosType(), $entity, array(
            'action' => $this->generateUrl('datoseventos_update', array('id' => $entity->getIdEventos())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing DatosEventos entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosEventos')->find($id);

        $actualUsuarioCreacion = $entity->getUsuarioCreacion();
        $actualFechaCreacion = $entity->getFechaCreacion();
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosEventos entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);


            
        if ($editForm->isValid()) {
            

            
            $usr= $this->get('security.context')->getToken()->getUser();
            $usuario = $usr->getUsername();
            $fecha = new \DateTime("now");
            $entity->setUsuarioUltimaModificacion($usuario);
            $entity->setFechaUltimaModificacion($fecha);
            $entity->setUsuarioCreacion($actualUsuarioCreacion);
            $entity->setFechaCreacion($actualFechaCreacion);
            
            
            $fechatmp = $entity->getFechaInicio();            
            $fecha = new \DateTime($fechatmp);
            $entity->setFechaInicio($fecha);
            
            $fechatmp = $entity->getFechaFinal();            
            $fecha = new \DateTime($fechatmp);
            $entity->setFechaFinal($fecha);
            

            
            
            $em->flush();

            return $this->redirect($this->generateUrl('datoseventos_edit', array('id' => $id)));
        }

        return $this->render('VictoriaAppBundle:DatosEventos:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a DatosEventos entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('VictoriaAppBundle:DatosEventos')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DatosEventos entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('datoseventos'));
    }

    /**
     * Creates a form to delete a DatosEventos entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('datoseventos_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
