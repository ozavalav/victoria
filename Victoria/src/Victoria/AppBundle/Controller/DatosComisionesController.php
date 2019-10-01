<?php

namespace Victoria\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Victoria\AppBundle\Entity\DatosComisiones;
use Victoria\AppBundle\Form\DatosComisionesType;

/**
 * DatosComisiones controller.
 *
 */
class DatosComisionesController extends Controller
{

    /**
     * Lists all DatosComisiones entities.
     *
     */
    public function indexAction(Request $request)
    {
        $session = $request->getSession();
        $menu = $session->get('_menu');
        $campana = $session->get('_id_campana');
        $distrito = $session->get('_id_distrito');
        
        $em = $this->getDoctrine()->getManager();
        
        if ($campana == 0 && $distrito == 0 ) {
            $entities = $em->getRepository('VictoriaAppBundle:DatosComisiones')->findAll();
        } else {
            $entities = $em->getRepository('VictoriaAppBundle:DatosComisiones')->findBy(array('idCampana' => $campana, 'idDistrito' => $distrito));
        }

        

        return $this->render('VictoriaAppBundle:DatosComisiones:index.html.twig', array(
            'entities' => $entities,
            'menu' => $menu,
        ));
    }
    /**
     * Creates a new DatosComisiones entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new DatosComisiones();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            /*Se agregan estas dos lineas por error al asignar el distrito y cv 
            $entity->setIdDistrito($entity->getIdDistrito()->getIdDistrito()); 
            $entity->setIdCv($entity->getIdCv()->getIdCv()); */
            
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('datoscomisiones_show', array('id' => $entity->getIdComision())));
        }

        return $this->render('VictoriaAppBundle:DatosComisiones:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a DatosComisiones entity.
     *
     * @param DatosComisiones $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DatosComisiones $entity)
    {
        $form = $this->createForm(new DatosComisionesType(), $entity, array(
            'action' => $this->generateUrl('datoscomisiones_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new DatosComisiones entity.
     *
     */
    public function newAction(Request $request)
    {
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        $entity = new DatosComisiones();
        $form   = $this->createCreateForm($entity);

        return $this->render('VictoriaAppBundle:DatosComisiones:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'menu' => $menu,
        ));
    }

    /**
     * Finds and displays a DatosComisiones entity.
     *
     */
    public function showAction(Request $request, $id)
    {
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosComisiones')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosComisiones entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VictoriaAppBundle:DatosComisiones:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'menu' => $menu,
        ));
    }

    /**
     * Displays a form to edit an existing DatosComisiones entity.
     *
     */
    public function editAction(Request $request, $id)
    {
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosComisiones')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosComisiones entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VictoriaAppBundle:DatosComisiones:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'menu' => $menu,
        ));
    }

    /**
    * Creates a form to edit a DatosComisiones entity.
    *
    * @param DatosComisiones $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(DatosComisiones $entity)
    {
        $form = $this->createForm(new DatosComisionesType(), $entity, array(
            'action' => $this->generateUrl('datoscomisiones_update', array('id' => $entity->getIdComision())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing DatosComisiones entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosComisiones')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosComisiones entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            
            /*Se agregan estas dos lineas por error al asignar el distrito y cv 
            $entity->setIdDistrito($entity->getIdDistrito()->getIdDistrito()); 
            $entity->setIdCv($entity->getIdCv()->getIdCv()); */
            
            $em->flush();

            return $this->redirect($this->generateUrl('datoscomisiones_edit', array('id' => $id)));
        }

        return $this->render('VictoriaAppBundle:DatosComisiones:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a DatosComisiones entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('VictoriaAppBundle:DatosComisiones')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DatosComisiones entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('datoscomisiones'));
    }

    /**
     * Creates a form to delete a DatosComisiones entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('datoscomisiones_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
