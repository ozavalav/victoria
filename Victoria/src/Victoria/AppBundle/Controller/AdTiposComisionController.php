<?php

namespace Victoria\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Victoria\AppBundle\Entity\AdTiposComision;
use Victoria\AppBundle\Form\AdTiposComisionType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * AdTiposComision controller.
 *
 */
class AdTiposComisionController extends Controller
{

    /**
     * Lists all AdTiposComision entities.
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
        $idUsuario = $session->get('_id_usuario');
        
        /* Obtiene las notificaciones que tiene el usuario */
        $entnot = $seg->obtenerNotificaciones($idUsuario);
        /* Obtiene las tareas que tiene el usuario */
        $enttar = $seg->obtenerTareas($idUsuario);
        
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('VictoriaAppBundle:AdTiposComision')->findAll();

        return $this->render('VictoriaAppBundle:AdTiposComision:index.html.twig', array(
        'entities' => $entities,
        'menu' => $menu,
        'datosnoti' => $entnot,   
        'datostar' => $enttar,    
        ));
    }
    /**
     * Creates a new AdTiposComision entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new AdTiposComision();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $entity->setIdEstructura($entity->getIdEstructura()->getIdEstructura());
            
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('adtiposcomision_show', array('id' => $entity->getIdTipoComision())));
        }

        return $this->render('VictoriaAppBundle:AdTiposComision:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a AdTiposComision entity.
     *
     * @param AdTiposComision $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(AdTiposComision $entity)
    {
        $form = $this->createForm(new AdTiposComisionType(), $entity, array(
            'action' => $this->generateUrl('adtiposcomision_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new AdTiposComision entity.
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
        
        $entity = new AdTiposComision();
        $form   = $this->createCreateForm($entity);

        return $this->render('VictoriaAppBundle:AdTiposComision:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'menu' => $menu,
        ));
    }

    /**
     * Finds and displays a AdTiposComision entity.
     *
     */
    public function showAction(Request $request, $id)
    {
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:AdTiposComision')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AdTiposComision entity.');
        }


        return $this->render('VictoriaAppBundle:AdTiposComision:show.html.twig', array(
            'entity'      => $entity,
            'menu' => $menu,
        ));
    }

    /**
     * Displays a form to edit an existing AdTiposComision entity.
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

        $entity = $em->getRepository('VictoriaAppBundle:AdTiposComision')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AdTiposComision entity.');
        }

        $editForm = $this->createEditForm($entity);

        return $this->render('VictoriaAppBundle:AdTiposComision:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'menu' => $menu,
            'idEstructura' => $entity->getIdEstructura(),
        ));
    }

    /**
    * Creates a form to edit a AdTiposComision entity.
    *
    * @param AdTiposComision $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(AdTiposComision $entity)
    {
        $form = $this->createForm(new AdTiposComisionType(), $entity, array(
            'action' => $this->generateUrl('adtiposcomision_update', array('id' => $entity->getIdTipoComision())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing AdTiposComision entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:AdTiposComision')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AdTiposComision entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            
            $entity->setIdEstructura($entity->getIdEstructura()->getIdEstructura());
            
            $em->flush();

            return $this->redirect($this->generateUrl('adtiposcomision_edit', array('id' => $id)));
        }

        return $this->render('VictoriaAppBundle:AdTiposComision:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a AdTiposComision entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('VictoriaAppBundle:AdTiposComision')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find AdTiposComision entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('adtiposcomision'));
    }

    /**
     * Creates a form to delete a AdTiposComision entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('adtiposcomision_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
