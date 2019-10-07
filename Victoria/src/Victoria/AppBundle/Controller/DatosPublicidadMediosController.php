<?php

namespace Victoria\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Victoria\AppBundle\Entity\DatosPublicidadMedios;
use Victoria\AppBundle\Form\DatosPublicidadMediosType;

/**
 * DatosPublicidadMedios controller.
 *
 */
class DatosPublicidadMediosController extends Controller
{

    /**
     * Lists all DatosPublicidadMedios entities.
     *
     */
    public function indexAction(Request $request)
    {
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('VictoriaAppBundle:DatosPublicidadMedios')->findAll();

        return $this->render('VictoriaAppBundle:DatosPublicidadMedios:index.html.twig', array(
            'entities' => $entities,
            'menu' => $menu
        ));
    }
    /**
     * Creates a new DatosPublicidadMedios entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new DatosPublicidadMedios();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('datospublicidadmedios_show', array('id' => $entity->getIdPublicidadMedios())));
        }

        return $this->render('VictoriaAppBundle:DatosPublicidadMedios:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a DatosPublicidadMedios entity.
     *
     * @param DatosPublicidadMedios $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DatosPublicidadMedios $entity)
    {
        $form = $this->createForm(new DatosPublicidadMediosType(), $entity, array(
            'action' => $this->generateUrl('datospublicidadmedios_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new DatosPublicidadMedios entity.
     *
     */
    public function newAction(Request $request)
    {
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        $entity = new DatosPublicidadMedios();
        $form   = $this->createCreateForm($entity);

        return $this->render('VictoriaAppBundle:DatosPublicidadMedios:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'menu' => $menu,
        ));
    }

    /**
     * Finds and displays a DatosPublicidadMedios entity.
     *
     */
    public function showAction(Request $request, $id)
    {
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        $em = $this->getDoctrine()->getManager();
        
        $entity = $em->getRepository('VictoriaAppBundle:DatosPublicidadMedios')->find($id);

        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosPublicidadMedios entity.');
        }


        return $this->render('VictoriaAppBundle:DatosPublicidadMedios:show.html.twig', array(
            'entity'      => $entity,
            'menu' => $menu,
        ));
    }

    /**
     * Displays a form to edit an existing DatosPublicidadMedios entity.
     *
     */
    public function editAction(Request $request, $id)
    {
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosPublicidadMedios')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosPublicidadMedios entity.');
        }

        $editForm = $this->createEditForm($entity);

        return $this->render('VictoriaAppBundle:DatosPublicidadMedios:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'menu' => $menu,
        ));
    }

    /**
    * Creates a form to edit a DatosPublicidadMedios entity.
    *
    * @param DatosPublicidadMedios $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(DatosPublicidadMedios $entity)
    {
        $form = $this->createForm(new DatosPublicidadMediosType(), $entity, array(
            'action' => $this->generateUrl('datospublicidadmedios_update', array('id' => $entity->getIdPublicidadMedios())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing DatosPublicidadMedios entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosPublicidadMedios')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosPublicidadMedios entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('datospublicidadmedios_edit', array('id' => $id)));
        }

        return $this->render('VictoriaAppBundle:DatosPublicidadMedios:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a DatosPublicidadMedios entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('VictoriaAppBundle:DatosPublicidadMedios')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DatosPublicidadMedios entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('datospublicidadmedios'));
    }

    /**
     * Creates a form to delete a DatosPublicidadMedios entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('datospublicidadmedios_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
