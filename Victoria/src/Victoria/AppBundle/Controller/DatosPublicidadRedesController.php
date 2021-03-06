<?php

namespace Victoria\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Victoria\AppBundle\Entity\DatosPublicidadRedes;
use Victoria\AppBundle\Form\DatosPublicidadRedesType;

/**
 * DatosPublicidadRedes controller.
 *
 */
class DatosPublicidadRedesController extends Controller
{

    /**
     * Lists all DatosPublicidadRedes entities.
     *
     */
    public function indexAction(Request $request)
    {
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('VictoriaAppBundle:DatosPublicidadRedes')->findAll();

        return $this->render('VictoriaAppBundle:DatosPublicidadRedes:index.html.twig', array(
            'entities' => $entities,
             'menu' => $menu
        ));
    }
    /**
     * Creates a new DatosPublicidadRedes entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new DatosPublicidadRedes();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('datospublicidadredes_show', array('id' => $entity->getIdPublicidadRedes())));
        }

        return $this->render('VictoriaAppBundle:DatosPublicidadRedes:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a DatosPublicidadRedes entity.
     *
     * @param DatosPublicidadRedes $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DatosPublicidadRedes $entity)
    {
        $form = $this->createForm(new DatosPublicidadRedesType(), $entity, array(
            'action' => $this->generateUrl('datospublicidadredes_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new DatosPublicidadRedes entity.
     *
     */
    public function newAction(Request $request)
    {
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        $entity = new DatosPublicidadRedes();
        $form   = $this->createCreateForm($entity);

        return $this->render('VictoriaAppBundle:DatosPublicidadRedes:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'menu' => $menu,
        ));
    }

    /**
     * Finds and displays a DatosPublicidadRedes entity.
     *
     */
    public function showAction(Request $request, $id)
    {
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosPublicidadRedes')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosPublicidadRedes entity.');
        }

        

        return $this->render('VictoriaAppBundle:DatosPublicidadRedes:show.html.twig', array(
            'entity'      => $entity,
             'menu' => $menu,
        ));
    }

    /**
     * Displays a form to edit an existing DatosPublicidadRedes entity.
     *
     */
    public function editAction(Request $request, $id)
    {
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosPublicidadRedes')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosPublicidadRedes entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VictoriaAppBundle:DatosPublicidadRedes:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'menu' => $menu,
        ));
    }

    /**
    * Creates a form to edit a DatosPublicidadRedes entity.
    *
    * @param DatosPublicidadRedes $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(DatosPublicidadRedes $entity)
    {
        $form = $this->createForm(new DatosPublicidadRedesType(), $entity, array(
            'action' => $this->generateUrl('datospublicidadredes_update', array('id' => $entity->getIdPublicidadRedes())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing DatosPublicidadRedes entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosPublicidadRedes')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosPublicidadRedes entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('datospublicidadredes_edit', array('id' => $id)));
        }

        return $this->render('VictoriaAppBundle:DatosPublicidadRedes:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a DatosPublicidadRedes entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('VictoriaAppBundle:DatosPublicidadRedes')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DatosPublicidadRedes entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('datospublicidadredes'));
    }

    /**
     * Creates a form to delete a DatosPublicidadRedes entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('datospublicidadredes_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
