<?php

namespace Victoria\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Victoria\AppBundle\Entity\DatosAportaciones;
use Victoria\AppBundle\Form\DatosAportacionesType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * DatosAportaciones controller.
 *
 */
class DatosAportacionesController extends Controller
{

    /**
     * Lists all DatosAportaciones entities.
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
        $idUsuario = $session->get('_id_usuario');
        
        /* Obtiene las notificaciones que tiene el usuario */
        $entnot = $seg->obtenerNotificaciones($idUsuario);
        /* Obtiene las tareas que tiene el usuario */
        $enttar = $seg->obtenerTareas($idUsuario);
        
        $em = $this->getDoctrine()->getManager();

        if($idCampana == 0) {
            $entities = $em->getRepository('VictoriaAppBundle:DatosAportaciones')->findAll();
        } else {
            $entities = $em->getRepository('VictoriaAppBundle:DatosAportaciones')->findBy(array('idCampana' => $idCampana));
        } 

        return $this->render('VictoriaAppBundle:DatosAportaciones:index.html.twig', array(
            'entities' => $entities,
            'menu' => $menu,
            'datosnoti' => $entnot,
            'datostar' => $enttar,
        ));
    }
    /**
     * Creates a new DatosAportaciones entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new DatosAportaciones();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('datosaportaciones_show', array('id' => $entity->getIdAportador())));
        }

        return $this->render('VictoriaAppBundle:DatosAportaciones:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a DatosAportaciones entity.
     *
     * @param DatosAportaciones $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DatosAportaciones $entity)
    {
        $form = $this->createForm(new DatosAportacionesType(), $entity, array(
            'action' => $this->generateUrl('datosaportaciones_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new DatosAportaciones entity.
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
        $idEstructura = $session->get('_id_estructura');
        
        $entity = new DatosAportaciones();
        $form   = $this->createCreateForm($entity);

        return $this->render('VictoriaAppBundle:DatosAportaciones:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'menu' => $menu,
        ));
    }

    /**
     * Finds and displays a DatosAportaciones entity.
     *
     */
    public function showAction(Request $request, $id)
    {
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosAportaciones')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosAportaciones entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VictoriaAppBundle:DatosAportaciones:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'menu' => $menu,
        ));
    }

    /**
     * Displays a form to edit an existing DatosAportaciones entity.
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

        $entity = $em->getRepository('VictoriaAppBundle:DatosAportaciones')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosAportaciones entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VictoriaAppBundle:DatosAportaciones:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'menu' => $menu,
        ));
    }

    /**
    * Creates a form to edit a DatosAportaciones entity.
    *
    * @param DatosAportaciones $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(DatosAportaciones $entity)
    {
        $form = $this->createForm(new DatosAportacionesType(), $entity, array(
            'action' => $this->generateUrl('datosaportaciones_update', array('id' => $entity->getIdAportador())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing DatosAportaciones entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosAportaciones')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosAportaciones entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('datosaportaciones_edit', array('id' => $id)));
        }

        return $this->render('VictoriaAppBundle:DatosAportaciones:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a DatosAportaciones entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('VictoriaAppBundle:DatosAportaciones')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DatosAportaciones entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('datosaportaciones'));
    }

    /**
     * Creates a form to delete a DatosAportaciones entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('datosaportaciones_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
