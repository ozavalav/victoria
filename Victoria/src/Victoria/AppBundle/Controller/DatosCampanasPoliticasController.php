<?php

namespace Victoria\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Victoria\AppBundle\Entity\DatosCampanasPoliticas;
use Victoria\AppBundle\Form\DatosCampanasPoliticasType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * DatosCampanasPoliticas controller.
 *
 */
class DatosCampanasPoliticasController extends Controller
{

    /**
     * Lists all DatosCampanasPoliticas entities.
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
        
        /* Carga las variables de sesion del usuarios necesarias para dibujar menu y filtar la información */
        $session = $request->getSession();
        $menu = $session->get('_menu');
        $idCampana = $session->get('_id_campana');
        $idDistrito = $session->get('_id_distrito');
        $idUsuario = $session->get('_id_usuario');
        
        /* Obtiene las notificaciones que tiene el usuario */
        $entnot = $seg->obtenerNotificaciones($idUsuario);
        
        $em = $this->getDoctrine()->getManager();

        if($idCampana == 0 && $idDistrito == 0) {
            $entities = $em->getRepository('VictoriaAppBundle:DatosCampanasPoliticas')->findAll();
        } elseif($idCampana != 0 && $idDistrito == 0 ) {
            $entities = $em->getRepository('VictoriaAppBundle:DatosCampanasPoliticas')->findBy(['idCampana' => $idCampana]);
        } else {
            $entities = $em->getRepository('VictoriaAppBundle:DatosCampanasPoliticas')->findBy(['idCampana' => $idCampana]);
        }
        return $this->render('VictoriaAppBundle:DatosCampanasPoliticas:index.html.twig', array(
            'entities' => $entities,
            'menu' => $menu,
            'datosnoti' => $entnot,
        ));
    }
    /**
     * Creates a new DatosCampanasPoliticas entity.
     * 
     */
    public function createAction(Request $request)
    {
        $entity = new DatosCampanasPoliticas();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('datoscampanaspoliticas_show', array('id' => $entity->getIdCampana())));
        }

        return $this->render('VictoriaAppBundle:DatosCampanasPoliticas:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a DatosCampanasPoliticas entity.
     *
     * @param DatosCampanasPoliticas $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DatosCampanasPoliticas $entity)
    {
        $form = $this->createForm(new DatosCampanasPoliticasType(), $entity, array(
            'action' => $this->generateUrl('datoscampanaspoliticas_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new DatosCampanasPoliticas entity.
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
        
        $entity = new DatosCampanasPoliticas();
        $form   = $this->createCreateForm($entity);

        return $this->render('VictoriaAppBundle:DatosCampanasPoliticas:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'menu' => $menu,
        ));
    }

    /**
     * Finds and displays a DatosCampanasPoliticas entity.
     *
     */
    public function showAction(Request $request, $id)
    {
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosCampanasPoliticas')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosCampanasPoliticas entity.');
        }

        return $this->render('VictoriaAppBundle:DatosCampanasPoliticas:show.html.twig', array(
            'entity'      => $entity,
            'menu' => $menu,
        ));
    }

    /**
     * Displays a form to edit an existing DatosCampanasPoliticas entity.
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

        $entity = $em->getRepository('VictoriaAppBundle:DatosCampanasPoliticas')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosCampanasPoliticas entity.');
        }

        $editForm = $this->createEditForm($entity);

        return $this->render('VictoriaAppBundle:DatosCampanasPoliticas:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'menu' => $menu,
        ));
    }

    /**
    * Creates a form to edit a DatosCampanasPoliticas entity.
    *
    * @param DatosCampanasPoliticas $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(DatosCampanasPoliticas $entity)
    {
        $form = $this->createForm(new DatosCampanasPoliticasType(), $entity, array(
            'action' => $this->generateUrl('datoscampanaspoliticas_update', array('id' => $entity->getIdCampana())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing DatosCampanasPoliticas entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosCampanasPoliticas')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosCampanasPoliticas entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('datoscampanaspoliticas_edit', array('id' => $id)));
        }

        return $this->render('VictoriaAppBundle:DatosCampanasPoliticas:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a DatosCampanasPoliticas entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('VictoriaAppBundle:DatosCampanasPoliticas')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DatosCampanasPoliticas entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('datoscampanaspoliticas'));
    }

    /**
     * Creates a form to delete a DatosCampanasPoliticas entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('datoscampanaspoliticas_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
