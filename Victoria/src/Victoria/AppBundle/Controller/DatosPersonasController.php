<?php

namespace Victoria\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Victoria\AppBundle\Entity\DatosPersonas;
use Victoria\AppBundle\Form\DatosPersonasType;

/**
 * DatosPersonas controller.
 *
 */
class DatosPersonasController extends Controller
{

    /**
     * Lists all DatosPersonas entities.
     *
     */
    public function indexAction(Request $request)
    {
        $session = $request->getSession();
        $menu = $session->get('_menu');
        $campana = $session->get('_id_campana');
        $distrito = $session->get('_id_distrito');
        $em = $this->getDoctrine()->getManager();
        
        if($campana == 0 ) {
            $entities = $em->getRepository('VictoriaAppBundle:DatosPersonas')->findAll();
        } else {
            $entities = $em->getRepository('VictoriaAppBundle:DatosPersonas')->findBy(array('idCampana' => $campana, 'idDistrito' => $distrito));
        }
        return $this->render('VictoriaAppBundle:DatosPersonas:index.html.twig', array(
            'entities' => $entities,
            'menu' => $menu,
        ));
    }
    /**
     * Creates a new DatosPersonas entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new DatosPersonas();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('datospersonas_show', array('id' => $entity->getIdPersona())));
        }

        return $this->render('VictoriaAppBundle:DatosPersonas:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a DatosPersonas entity.
     *
     * @param DatosPersonas $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DatosPersonas $entity)
    {
        $form = $this->createForm(new DatosPersonasType(), $entity, array(
            'action' => $this->generateUrl('datospersonas_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new DatosPersonas entity.
     *
     */
    public function newAction(Request $request)
    {
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        $entity = new DatosPersonas();
        $form   = $this->createCreateForm($entity);

        return $this->render('VictoriaAppBundle:DatosPersonas:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'menu' => $menu,
        ));
    }

    /**
     * Finds and displays a DatosPersonas entity.
     *
     */
    public function showAction(Request $request, $id)
    {
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosPersonas')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosPersonas entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VictoriaAppBundle:DatosPersonas:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'menu' => $menu,
        ));
    }

    /**
     * Displays a form to edit an existing DatosPersonas entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosPersonas')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosPersonas entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VictoriaAppBundle:DatosPersonas:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a DatosPersonas entity.
    *
    * @param DatosPersonas $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(DatosPersonas $entity)
    {
        $form = $this->createForm(new DatosPersonasType(), $entity, array(
            'action' => $this->generateUrl('datospersonas_update', array('id' => $entity->getIdPersona())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing DatosPersonas entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosPersonas')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosPersonas entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('datospersonas_edit', array('id' => $id)));
        }

        return $this->render('VictoriaAppBundle:DatosPersonas:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a DatosPersonas entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('VictoriaAppBundle:DatosPersonas')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DatosPersonas entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('datospersonas'));
    }

    /**
     * Creates a form to delete a DatosPersonas entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('datospersonas_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
