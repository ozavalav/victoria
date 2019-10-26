<?php

namespace Victoria\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Victoria\AppBundle\Entity\DatosListaPublicidad;
use Victoria\AppBundle\Form\DatosListaPublicidadType;

/**
 * DatosListaPublicidad controller.
 *
 */
class DatosListaPublicidadController extends Controller
{

    /**
     * Lists all DatosListaPublicidad entities.
     *
     */
    public function indexAction(Request $request, $id)
    {$seg = $this->container->get('victoria_app.vicseguridad');
        
        /* Verifica que el usuario este autenticado */
        $ok = $seg->validarUsuario();
        
        /* Verifica que el usuario tenga acceso a esta ruta o opción 
        $ruta = $request->attributes->get('_route'); 
        $ok = $seg->comprobarAcceso($ruta); */
        
        $em = $this->getDoctrine()->getManager();
        
        /* Carga las variables de sesion del usuarios necesarias para dibujar menu y filtar la información */
        $session = $request->getSession();
        $menu = $session->get('_menu');

        $entities = $em->getRepository('VictoriaAppBundle:DatosListaPublicidad')->findBy(array('idPublicidad' => $id));
        
         /* Preparo el formulario para agregar nuevo item */
        $entity = new DatosListaPublicidad();
        $form   = $this->createCreateForm($entity);

        return $this->render('VictoriaAppBundle:DatosListaPublicidad:index.html.twig', array(
            'entities' => $entities,
            'form' => $form->createView(),
            'menu' => $menu,
            'idpublicidad' => $id,
        ));
    }
    /**
     * Creates a new DatosListaPublicidad entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new DatosListaPublicidad();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $idpub = (int)$request->get('idpublicidad');

            $entity->setIdPublicidad($idpub);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('datoslistapublicidad_list', array('id' => $idpub)));
        }

        return $this->render('VictoriaAppBundle:DatosListaPublicidad:new.html.twig', array('id' => $idpub));

    }

    /**
     * Creates a form to create a DatosListaPublicidad entity.
     *
     * @param DatosListaPublicidad $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DatosListaPublicidad $entity)
    {
        $form = $this->createForm(new DatosListaPublicidadType(), $entity, array(
            'action' => $this->generateUrl('datoslistapublicidad_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Agregar'));

        return $form;
    }

    /**
     * Displays a form to create a new DatosListaPublicidad entity.
     *
     */
    public function newAction()
    {
        $entity = new DatosListaPublicidad();
        $form   = $this->createCreateForm($entity);

        return $this->render('VictoriaAppBundle:DatosListaPublicidad:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a DatosListaPublicidad entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosListaPublicidad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosListaPublicidad entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VictoriaAppBundle:DatosListaPublicidad:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing DatosListaPublicidad entity.
     *
     */
    public function editAction(Request $request, $id)
    {
        $seg = $this->container->get('victoria_app.vicseguridad');
        
        /* Verifica que el usuario este autenticado */
        $ok = $seg->validarUsuario();
        
        /* Verifica que el usuario tenga acceso a esta ruta o opción 
        $ruta = $request->attributes->get('_route'); 
        $ok = $seg->comprobarAcceso($ruta); */
        
        $em = $this->getDoctrine()->getManager();
        
        /* Carga las variables de sesion del usuarios necesarias para dibujar menu y filtar la información */
        $session = $request->getSession();
        $menu = $session->get('_menu');
        

        $entity = $em->getRepository('VictoriaAppBundle:DatosListaPublicidad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosListaPublicidad entity.');
        }        
        $idpub = (int)$entity->getIdPublicidad();

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('datoslistapublicidad_list', array('id' => $idpub)));
        }

        return $this->render('VictoriaAppBundle:DatosListaPublicidad:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'menu' => $menu,
            'idpub' => $idpub,
        ));
    }

    /**
    * Creates a form to edit a DatosListaPublicidad entity.
    *
    * @param DatosListaPublicidad $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(DatosListaPublicidad $entity)
    {
        $form = $this->createForm(new DatosListaPublicidadType(), $entity, array(
            'action' => $this->generateUrl('datoslistapublicidad_update', array('id' => $entity->getIdLista())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing DatosListaPublicidad entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosListaPublicidad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosListaPublicidad entity.');
        }
        $idpub = $entity->getIdPublicidad();


        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
           $entity->setIdPublicidad($idpub);

            $em->flush();

            return $this->redirect($this->generateUrl('datoslistapublicidad_edit', array('id' => $id)));
        }

        return $this->render('VictoriaAppBundle:DatosListaPublicidad:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a DatosListaPublicidad entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        //if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('VictoriaAppBundle:DatosListaPublicidad')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DatosListaPublicidad entity.');
            }
            $idpub = $entity->getIdPublicidad();

            $em->remove($entity);
            $em->flush();
        //}

        return $this->redirect($this->generateUrl('datoslistapublicidad_list', array('id' => $idpub)));
    }

    /**
     * Creates a form to delete a DatosListaPublicidad entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('datoslistapublicidad_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
