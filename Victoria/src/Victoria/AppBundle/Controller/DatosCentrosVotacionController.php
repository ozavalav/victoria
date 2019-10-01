<?php

namespace Victoria\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Victoria\AppBundle\Entity\DatosCentrosVotacion;
use Victoria\AppBundle\Form\DatosCentrosVotacionType;

/**
 * DatosCentrosVotacion controller.
 *
 */
class DatosCentrosVotacionController extends Controller
{

    /**
     * Lists all DatosCentrosVotacion entities.
     *
     */
    public function indexAction(Request $request, $id = 0)
    {
        $session = $request->getSession();
        $menu = $session->get('_menu');
        $distrito = $session->get('_id_distrito');
        
        $em = $this->getDoctrine()->getManager();
        
        /* Valida el nivel de acceso para ver todos los CV o solamente los que tiene acceso */
        if($distrito == 0 && $id == 0) {
            $entities = $em->getRepository('VictoriaAppBundle:DatosCentrosVotacion')->findAll();
        } else {
            $entities = $em->getRepository('VictoriaAppBundle:DatosCentrosVotacion')->findBy(array('idDistrito' => $distrito));
        }

        return $this->render('VictoriaAppBundle:DatosCentrosVotacion:index.html.twig', array(
            'entities' => $entities,
            'menu' => $menu
        ));
    }
    /**
     * Creates a new DatosCentrosVotacion entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new DatosCentrosVotacion();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('datoscentrosvotacion_show', array('id' => $entity->getIdcv())));
        }

        return $this->render('VictoriaAppBundle:DatosCentrosVotacion:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a DatosCentrosVotacion entity.
     *
     * @param DatosCentrosVotacion $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DatosCentrosVotacion $entity)
    {
        $form = $this->createForm(new DatosCentrosVotacionType(), $entity, array(
            'action' => $this->generateUrl('datoscentrosvotacion_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new DatosCentrosVotacion entity.
     *
     */
    public function newAction(Request $request)
    {
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        $entity = new DatosCentrosVotacion();
        $form   = $this->createCreateForm($entity);

        return $this->render('VictoriaAppBundle:DatosCentrosVotacion:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'menu' => $menu,
        ));
    }

    /**
     * Finds and displays a DatosCentrosVotacion entity.
     *
     */
    public function showAction(Request $request, $id)
    {
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosCentrosVotacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosCentrosVotacion entity.');
        }



        return $this->render('VictoriaAppBundle:DatosCentrosVotacion:show.html.twig', array(
            'entity'      => $entity,
            'menu' => $menu,
        ));
    }

    /**
     * Displays a form to edit an existing DatosCentrosVotacion entity.
     *
     */
    public function editAction(Request $request, $id)
    {
        
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosCentrosVotacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosCentrosVotacion entity.');
        }

        $editForm = $this->createEditForm($entity);

        return $this->render('VictoriaAppBundle:DatosCentrosVotacion:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'menu' => $menu,
        ));
    }

    /**
    * Creates a form to edit a DatosCentrosVotacion entity.
    *
    * @param DatosCentrosVotacion $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(DatosCentrosVotacion $entity)
    {
        $form = $this->createForm(new DatosCentrosVotacionType(), $entity, array(
            'action' => $this->generateUrl('datoscentrosvotacion_update', array('idCv' => $entity->getIdCv())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing DatosCentrosVotacion entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosCentrosVotacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosCentrosVotacion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('datoscentrosvotacion_edit', array('idCv' => $id)));
        }

        return $this->render('VictoriaAppBundle:DatosCentrosVotacion:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a DatosCentrosVotacion entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('VictoriaAppBundle:DatosCentrosVotacion')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DatosCentrosVotacion entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('datoscentrosvotacion'));
    }

    /**
     * Creates a form to delete a DatosCentrosVotacion entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('datoscentrosvotacion_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
