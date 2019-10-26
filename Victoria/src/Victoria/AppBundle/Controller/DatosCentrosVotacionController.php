<?php

namespace Victoria\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Victoria\AppBundle\Entity\DatosCentrosVotacion;
use Victoria\AppBundle\Form\DatosCentrosVotacionType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

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
        
        /* Valida el nivel de acceso para ver todos los CV o solamente los que tiene acceso */
        
        if($id != 0) {
            $entities = $em->getRepository('VictoriaAppBundle:DatosCentrosVotacion')->findBy(array('idDistrito' => $id));
        } elseif($idCampana == 0 && $idDistrito == 0) {
            $entities = $em->getRepository('VictoriaAppBundle:DatosCentrosVotacion')->findAll();
        } elseif($idCampana != 0 && $idDistrito == 0) {
            $entities = $em->getRepository('VictoriaAppBundle:DatosCentrosVotacion')->findBy(array('idCampana' => $idCampana));
        } else {
            $entities = $em->getRepository('VictoriaAppBundle:DatosCentrosVotacion')->findBy(array('idCampana' => $idCampana, 'idDistrito' => $idDistrito )); 
        }
        
        return $this->render('VictoriaAppBundle:DatosCentrosVotacion:index.html.twig', array(
            'entities' => $entities,
            'menu' => $menu,
            'datosnoti' => $entnot,
        ));
    }
    /**
     * Creates a new DatosCentrosVotacion entity.
     *
     */
    public function createAction(Request $request)
    {
        $session = $request->getSession();
        $idCampana = $session->get('_id_campana');
        $menu = $session->get('_menu');
        
        $entity = new DatosCentrosVotacion();
        $form = $this->createCreateForm($entity, $idCampana);
        $form->handleRequest($request);
        
        $em = $this->getDoctrine()->getManager();
        $idDis = $request->get('victoria_appbundle_datoscentrosvotacion')['idDistrito'];
        $entdis = $em->getRepository('VictoriaAppBundle:DatosDistritos')->findBy(array('idDistrito' => $idDis));
        $entity->setIdDistrito($entdis[0]);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('datoscentrosvotacion_show', array('id' => $entity->getIdcv())));
        }

        return $this->render('VictoriaAppBundle:DatosCentrosVotacion:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'menu' => $menu,
        ));
    }

    /**
     * Creates a form to create a DatosCentrosVotacion entity.
     *
     * @param DatosCentrosVotacion $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DatosCentrosVotacion $entity, $idCampana)
    {
        $form = $this->createForm(new DatosCentrosVotacionType(), $entity, array(
            'action' => $this->generateUrl('datoscentrosvotacion_create'),
            'method' => 'POST',
            'label' => $idCampana,
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new DatosCentrosVotacion entity.
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
        
        $entity = new DatosCentrosVotacion();
        $form   = $this->createCreateForm($entity, $idCampana);

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
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosCentrosVotacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosCentrosVotacion entity.');
        }

        $editForm = $this->createEditForm($entity, $idCampana);

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
    private function createEditForm(DatosCentrosVotacion $entity, $idCampana)
    {
        $form = $this->createForm(new DatosCentrosVotacionType(), $entity, array(
            'action' => $this->generateUrl('datoscentrosvotacion_update', array('id' => $entity->getIdCv())),
            'method' => 'PUT',
            'label' => $idCampana,
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
        $session = $request->getSession();
        $idCampana = $session->get('_id_campana');
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosCentrosVotacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosCentrosVotacion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity, $idCampana);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('datoscentrosvotacion_edit', array('id' => $id)));
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
