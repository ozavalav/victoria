<?php

namespace Victoria\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Victoria\AppBundle\Entity\DatosRespuestasCuestionario;
use Victoria\AppBundle\Form\DatosRespuestasCuestionarioType;

/**
 * DatosRespuestasCuestionario controller.
 *
 */
class DatosRespuestasCuestionarioController extends Controller
{

    /**
     * Lists all DatosRespuestasCuestionario entities.
     *
     */
    public function indexAction(Request $request)
    {
        $seg = $this->container->get('victoria_app.vicseguridad');
        
        /* Verifica que el usuario este autenticado */
        $ok = $seg->validarUsuario();
        

        
        $session = $request->getSession();
        $menu = $session->get('_menu');
        $idCampana = $session->get('_id_campana');
        $idDistrito = $session->get('_id_distrito');
        $idUsuario = $session->get('_id_usuario');
        
        /* Obtiene las notificaciones que tiene el usuario */
        $entnot = $seg->obtenerNotificaciones($idUsuario);
        
        $em = $this->getDoctrine()->getManager();
        
        if($idCampana == 0 && $idDistrito == 0) {
            $entities = $em->getRepository('VictoriaAppBundle:DatosRespuestasCuestionario')->findAll();
        } elseif ($idCampana != 0 && $idDistrito == 0) {
            $entities = $em->getRepository('VictoriaAppBundle:DatosRespuestasCuestionario')->findBy(array('idCampana' => $idCampana));
        } else {
            $entities = $em->getRepository('VictoriaAppBundle:DatosRespuestasCuestionario')->findBy(array('idCampana' => $idCampana, 'idDistrito' => $idDistrito));
        }
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('VictoriaAppBundle:DatosRespuestasCuestionario')->findAll();

        return $this->render('VictoriaAppBundle:DatosRespuestasCuestionario:index.html.twig', array(
            'entities' => $entities,
            'menu' => $menu,
            'datosnoti' => $entnot,    
        ));
    }
    /**
     * Creates a new DatosRespuestasCuestionario entity.
     *
     */
    public function createAction(Request $request)
    {
        $session = $request->getSession();
        $idCampana = $session->get('_id_campana');
        $idEstructura = $session->get('_id_estructura');
        
        
        $entity = new DatosRespuestasCuestionario();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            //return $this->redirect($this->generateUrl('datosrespuestascuestionario_show', array('id' => $entity->getIdRespuestaCuestionario())));
            return $this->redirect($this->generateUrl('datosrespuestascuestionario'));
        }

        return $this->render('VictoriaAppBundle:DatosRespuestasCuestionario:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a DatosRespuestasCuestionario entity.
     *
     * @param DatosRespuestasCuestionario $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DatosRespuestasCuestionario $entity)
    {
        $form = $this->createForm(new DatosRespuestasCuestionarioType(), $entity, array(
            'action' => $this->generateUrl('datosrespuestascuestionario_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new DatosRespuestasCuestionario entity.
     *
     */
    public function newAction(Request $request)
    {
        $seg = $this->container->get('victoria_app.vicseguridad');
        
        /* Verifica que el usuario este autenticado */
        $ok = $seg->validarUsuario();
        

        
        $session = $request->getSession();
        $menu = $session->get('_menu');

        
        
        $entity = new DatosRespuestasCuestionario();
        $form   = $this->createCreateForm($entity);

        return $this->render('VictoriaAppBundle:DatosRespuestasCuestionario:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'menu' => $menu,
        ));
    }

    /**
     * Finds and displays a DatosRespuestasCuestionario entity.
     *
     */
    public function showAction(Request $request, $id)
    {
        
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosRespuestasCuestionario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosRespuestasCuestionario entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VictoriaAppBundle:DatosRespuestasCuestionario:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'menu' => $menu,
        ));
    }

    /**
     * Displays a form to edit an existing DatosRespuestasCuestionario entity.
     *
     */
    public function editAction(Request $request, $id)
    {
        
       $seg = $this->container->get('victoria_app.vicseguridad');
        
        /* Verifica que el usuario este autenticado */
        $ok = $seg->validarUsuario();
        

        
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosRespuestasCuestionario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosRespuestasCuestionario entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VictoriaAppBundle:DatosRespuestasCuestionario:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'menu' => $menu,
        ));
    }

    /**
    * Creates a form to edit a DatosRespuestasCuestionario entity.
    *
    * @param DatosRespuestasCuestionario $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(DatosRespuestasCuestionario $entity)
    {
        $form = $this->createForm(new DatosRespuestasCuestionarioType(), $entity, array(
            'action' => $this->generateUrl('datosrespuestascuestionario_update', array('id' => $entity->getIdRespuestaCuestionario())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing DatosRespuestasCuestionario entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosRespuestasCuestionario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosRespuestasCuestionario entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('datosrespuestascuestionario_edit', array('id' => $id)));
        }

        return $this->render('VictoriaAppBundle:DatosRespuestasCuestionario:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a DatosRespuestasCuestionario entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('VictoriaAppBundle:DatosRespuestasCuestionario')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DatosRespuestasCuestionario entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('datosrespuestascuestionario'));
    }

    /**
     * Creates a form to delete a DatosRespuestasCuestionario entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('datosrespuestascuestionario_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
