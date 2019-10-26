<?php

namespace Victoria\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Victoria\AppBundle\Entity\DatosPersonas;
use Victoria\AppBundle\Form\DatosPersonasType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

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
        $seg = $this->container->get('victoria_app.vicseguridad');
        
        /* Verifica que el usuario este autenticado */
        $ok = $seg->validarUsuario();
        
        /* Verifica que el usuario tenga acceso a esta ruta o opción */
        $ruta = $request->attributes->get('_route'); 
        $ok = $seg->comprobarAcceso($ruta);
        
        $session = $request->getSession();
        $menu = $session->get('_menu');
        $idCampana = $session->get('_id_campana');
        $idDistrito = $session->get('_id_distrito');
        $idUsuario = $session->get('_id_usuario');
        
        /* Obtiene las notificaciones que tiene el usuario */
        $entnot = $seg->obtenerNotificaciones($idUsuario);
        
        $em = $this->getDoctrine()->getManager();
        
        if($idCampana == 0 && $idDistrito == 0) {
            $entities = $em->getRepository('VictoriaAppBundle:DatosPersonas')->findAll();
        } elseif ($idCampana != 0 && $idDistrito == 0) {
            $entities = $em->getRepository('VictoriaAppBundle:DatosPersonas')->findBy(array('idCampana' => $idCampana));
        } else {
            $entities = $em->getRepository('VictoriaAppBundle:DatosPersonas')->findBy(array('idCampana' => $idCampana, 'idDistrito' => $idDistrito));
        }
        
        return $this->render('VictoriaAppBundle:DatosPersonas:index.html.twig', array(
            'entities' => $entities,
            'menu' => $menu,
            'datosnoti' => $entnot,    
        ));
    }
    /**
     * Creates a new DatosPersonas entity.
     *
     */
    public function createAction(Request $request)
    {
        $session = $request->getSession();
        $idCampana = $session->get('_id_campana');
        $idEstructura = $session->get('_id_estructura');
        
        $entity = new DatosPersonas();
        $form = $this->createCreateForm($entity, $idCampana, $idEstructura);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $entity->setIdEstructura($entity->getIdEstructura()->getIdEstructura());
            $entity->setIdComision($entity->getIdComision()->getIdTipoComision());
            $entity->setEstado(1); // 1 = activo, 2 = inactivo
            
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
    private function createCreateForm(DatosPersonas $entity, $idCampana, $idEstructura)
    {
        $form = $this->createForm(new DatosPersonasType(), $entity, array(
            'action' => $this->generateUrl('datospersonas_create'),
            'method' => 'POST',
            'label' => $idCampana,
            'attr' => array('estructura' => $idEstructura),
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new DatosPersonas entity.
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
        $idCampana = $session->get('_id_campana');
        $idEstructura = $session->get('_id_estructura');
        
        $entity = new DatosPersonas();
        $form   = $this->createCreateForm($entity, $idCampana, $idEstructura);

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
        $idCampana = $session->get('_id_campana');
        $idEstructura = $session->get('_id_estructura');
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosPersonas')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosPersonas entity.');
        }

        $editForm = $this->createEditForm($entity, $idCampana, $idEstructura);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VictoriaAppBundle:DatosPersonas:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'menu' => $menu,
            'idEstructura' => $entity->getIdEstructura(),
            'idComision' => $entity->getIdComision(),
        ));
    }

    /**
    * Creates a form to edit a DatosPersonas entity.
    *
    * @param DatosPersonas $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(DatosPersonas $entity, $idCampana, $idEstructura)
    {
        $form = $this->createForm(new DatosPersonasType(), $entity, array(
            'action' => $this->generateUrl('datospersonas_update', array('id' => $entity->getIdPersona())),
            'method' => 'PUT',
            'label' => $idCampana,
            'attr' => array('estructura' => $idEstructura),
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
        $session = $request->getSession();
        $idCampana = $session->get('_id_campana');
        $idEstructura = $session->get('_id_estructura');
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosPersonas')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosPersonas entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity, $idCampana, $idEstructura);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            
            $entity->setIdEstructura($entity->getIdEstructura()->getIdEstructura());
            $entity->setIdComision($entity->getIdComision()->getIdTipoComision());
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
