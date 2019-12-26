<?php

namespace Victoria\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Victoria\AppBundle\Entity\DatosEquipos;
use Victoria\AppBundle\Form\DatosEquiposType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * DatosEquipos controller.
 *
 */
class DatosEquiposController extends Controller
{

    /**
     * Lists all DatosEquipos entities.
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
            $entities = $em->getRepository('VictoriaAppBundle:DatosEquipos')->findAll();
        } else {
            $entities = $em->getRepository('VictoriaAppBundle:DatosEquipos')->findBy(array('idCampana' => $idCampana));
        }
        
        return $this->render('VictoriaAppBundle:DatosEquipos:index.html.twig', array(
            'entities' => $entities,
            'menu' => $menu,
            'datosnoti' => $entnot,
            'datostar' => $enttar,
        ));
    }
    /**
     * Creates a new DatosEquipos entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new DatosEquipos();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('datosequipos_show', array('id' => $entity->getIdEquipo())));
        }

        return $this->render('VictoriaAppBundle:DatosEquipos:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a DatosEquipos entity.
     *
     * @param DatosEquipos $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DatosEquipos $entity)
    {
        $form = $this->createForm(new DatosEquiposType(), $entity, array(
            'action' => $this->generateUrl('datosequipos_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new DatosEquipos entity.
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
        
        $entity = new DatosEquipos();
        $form   = $this->createCreateForm($entity);

        return $this->render('VictoriaAppBundle:DatosEquipos:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'menu' => $menu,
        ));
    }

    /**
     * Finds and displays a DatosEquipos entity.
     *
     */
    public function showAction(Request $request, $id)
    {
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosEquipos')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosEquipos entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VictoriaAppBundle:DatosEquipos:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'menu' => $menu,
        ));
    }

    /**
     * Displays a form to edit an existing DatosEquipos entity.
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

        $entity = $em->getRepository('VictoriaAppBundle:DatosEquipos')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosEquipos entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VictoriaAppBundle:DatosEquipos:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'menu' => $menu,
        ));
    }

    /**
    * Creates a form to edit a DatosEquipos entity.
    *
    * @param DatosEquipos $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(DatosEquipos $entity)
    {
        $form = $this->createForm(new DatosEquiposType(), $entity, array(
            'action' => $this->generateUrl('datosequipos_update', array('id' => $entity->getIdEquipo())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing DatosEquipos entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosEquipos')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosEquipos entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('datosequipos_edit', array('id' => $id)));
        }

        return $this->render('VictoriaAppBundle:DatosEquipos:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a DatosEquipos entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('VictoriaAppBundle:DatosEquipos')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DatosEquipos entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('datosequipos'));
    }

    /**
     * Creates a form to delete a DatosEquipos entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('datosequipos_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
