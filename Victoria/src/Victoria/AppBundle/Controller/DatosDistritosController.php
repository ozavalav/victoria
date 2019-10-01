<?php

namespace Victoria\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Victoria\AppBundle\Entity\DatosDistritos;
use Victoria\AppBundle\Form\DatosDistritosType;

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
        $session = $request->getSession();
        $menu = $session->get('_menu');
        $campana = $session->get('_id_campana');
        
        $em = $this->getDoctrine()->getManager();

        /* Valida si selecciona todos los ditritos para visualizar */
        if($campana == 0 && $id == 0) {
            $entities = $em->getRepository('VictoriaAppBundle:DatosDistritos')->findAll();
        } else {
            $entities = $em->getRepository('VictoriaAppBundle:DatosDistritos')->findBy(array('idCampana' => $campana));
        }
        
        return $this->render('VictoriaAppBundle:DatosDistritos:index.html.twig', array(
            'entities' => $entities,
            'menu' => $menu,
        ));
    }
    /**
     * Creates a new DatosDistritos entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new DatosDistritos();
        $form = $this->createCreateForm($entity);
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

    /**
     * Creates a form to create a DatosDistritos entity.
     *
     * @param DatosDistritos $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DatosDistritos $entity)
    {
        $form = $this->createForm(new DatosDistritosType(), $entity, array(
            'action' => $this->generateUrl('datosdistritos_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new DatosDistritos entity.
     *
     */
    public function newAction(Request $request)
    {
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        $entity = new DatosDistritos();
        $form   = $this->createCreateForm($entity);

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
     * Displays a form to edit an existing DatosDistritos entity.
     *
     */
    public function editAction(Request $request, $id)
    {
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosDistritos')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosDistritos entity.');
        }

        $editForm = $this->createEditForm($entity);
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
    private function createEditForm(DatosDistritos $entity)
    {
        $form = $this->createForm(new DatosDistritosType(), $entity, array(
            'action' => $this->generateUrl('datosdistritos_update', array('id' => $entity->getIdDistrito())),
            'method' => 'PUT',
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
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosDistritos')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosDistritos entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
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
}
