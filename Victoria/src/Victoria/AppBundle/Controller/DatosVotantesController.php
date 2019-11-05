<?php

namespace Victoria\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Victoria\AppBundle\Entity\DatosVotantes;
use Victoria\AppBundle\Form\DatosVotantesType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * DatosVotantes controller.
 *
 */
class DatosVotantesController extends Controller
{

    /**
     * Lists all DatosVotantes entities.
     *
     */
    public function indexAction(Request $request, $modal = 0, $cvot = 0)
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
        
        
        $entities = null;
        /* Muestra los registros de los votantes segun el CV seleccionado */
        if($cvot != 0 ) {
            $entities = $em->getRepository('VictoriaAppBundle:DatosVotantes')->findBy(array('idCv' => $cvot));
        }
        
        /* Prepara el campo select - listado de Centros de Votacion */
        if($idCampana == 0 && $idDistrito == 0 ) {
            $entcv = $em->getRepository('VictoriaAppBundle:DatosCentrosVotacion')->findAll();
        } else {
            $entcv = $em->getRepository('VictoriaAppBundle:DatosCentrosVotacion')->findBy(array('idCampana' => $idCampana, 'idDistrito' => $idDistrito));
        }
        
        /* Crea la forma para ingresar nuevos votantes */
        $entity = new DatosVotantes();
        $form   = $this->createCreateForm($entity);
        
        return $this->render('VictoriaAppBundle:DatosVotantes:index.html.twig', array(
            'entities' => $entities,
            'menu' => $menu,
            'form' => $form->createView(),
            'datosnoti' => $entnot,
            'entcv' => $entcv,
            'modal' => $modal,
            'centrov' => $cvot,
        ));
    }
    /**
     * Creates a new DatosVotantes entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new DatosVotantes();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();    
            
            $accion = $form->get('submitadd')->isClicked();
        }
        
        if($accion) {
            return $this->redirect($this->generateUrl('datosvotantes_filtros', array('modal' => 1 )));
        }
        return $this->redirect($this->generateUrl('datosvotantes'));
        
    }

    /**
     * Creates a form to create a DatosVotantes entity.
     *
     * @param DatosVotantes $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DatosVotantes $entity)
    {
        $form = $this->createForm(new DatosVotantesType(), $entity, array(
            'action' => $this->generateUrl('datosvotantes_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Guardar'))
                ->add('submitadd', 'submit',array('label' => 'Guardar y Agregar'));
        return $form;
    }

    /**
     * Displays a form to create a new DatosVotantes entity.
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
        
        $entity = new DatosVotantes();
        $form   = $this->createCreateForm($entity);

        return $this->render('VictoriaAppBundle:DatosVotantes:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'menu' => $menu,
        ));
    }

    /**
     * Finds and displays a DatosVotantes entity.
     *
     */
    public function showAction(Request $request, $id)
    {
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosVotantes')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosVotantes entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VictoriaAppBundle:DatosVotantes:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'menu' => $menu,
        ));
    }

    /**
     * Displays a form to edit an existing DatosVotantes entity.
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editAction(Request $request,$id)
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

        $entity = $em->getRepository('VictoriaAppBundle:DatosVotantes')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosVotantes entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VictoriaAppBundle:DatosVotantes:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'menu' => $menu,
        ));
    }

    /**
    * Creates a form to edit a DatosVotantes entity.
    *
    * @param DatosVotantes $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(DatosVotantes $entity)
    {
        $form = $this->createForm(new DatosVotantesType(), $entity, array(
            'action' => $this->generateUrl('datosvotantes_update', array('id' => $entity->getIdVotante())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing DatosVotantes entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosVotantes')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosVotantes entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('datosvotantes_edit', array('id' => $id)));
        }

        return $this->render('VictoriaAppBundle:DatosVotantes:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a DatosVotantes entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('VictoriaAppBundle:DatosVotantes')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DatosVotantes entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('datosvotantes'));
    }

    /**
     * Creates a form to delete a DatosVotantes entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('datosvotantes_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
