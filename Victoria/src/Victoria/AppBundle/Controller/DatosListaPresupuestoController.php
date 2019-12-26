<?php

namespace Victoria\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Victoria\AppBundle\Entity\DatosListaPresupuesto;
use Victoria\AppBundle\Form\DatosListaPresupuestoType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * DatosListaPresupuesto controller.
 *
 */
class DatosListaPresupuestoController extends Controller
{

    /**
     * Lists all DatosListaPresupuesto entities.
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction(Request $request, $id)
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
        $idUsuario = $session->get('_id_usuario');
        
        /* Obtiene las notificaciones que tiene el usuario */
        $entnot = $seg->obtenerNotificaciones($idUsuario);
        /* Obtiene las tareas que tiene el usuario */
        $enttar = $seg->obtenerTareas($idUsuario);

        $entities = $em->getRepository('VictoriaAppBundle:DatosListaPresupuesto')->findBy(array('idPresupuesto' => $id ));

        /* Preparo el formulario para agregar nuevo item */
        $entity = new DatosListaPresupuesto();
        $form   = $this->createCreateForm($entity);
        
        return $this->render('VictoriaAppBundle:DatosListaPresupuesto:index.html.twig', array(
            'entities' => $entities,
            'form' => $form->createView(),
            'menu' => $menu,
            'datosnoti' => $entnot,
            'datostar' => $enttar,
            'idpresupuesto' => $id,
        ));
    }
    /**
     * Creates a new DatosListaPresupuesto entity.
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function createAction(Request $request)
    {
    
        $entity = new DatosListaPresupuesto();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $idpre = (int)$request->get('idpresupuesto');
            
            $entpre = $em->getRepository('VictoriaAppBundle:DatosPresupuestos')->find($idpre);
            $entity->setIdPresupuesto($entpre);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('datoslistapresupuesto_list', array('id' => $idpre)));
        }

        return $this->redirect($this->generateUrl('datoslistapresupuesto_list', array('id' => $idpre)));
    }

    /**
     * Creates a form to create a DatosListaPresupuesto entity.
     *
     * @param DatosListaPresupuesto $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DatosListaPresupuesto $entity)
    {
        $form = $this->createForm(new DatosListaPresupuestoType(), $entity, array(
            'action' => $this->generateUrl('datoslistapresupuesto_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Agregar'));

        return $form;
    }

    /**
     * Displays a form to create a new DatosListaPresupuesto entity.
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newAction()
    {
        $entity = new DatosListaPresupuesto();
        $form   = $this->createCreateForm($entity);

        return $this->render('VictoriaAppBundle:DatosListaPresupuesto:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a DatosListaPresupuesto entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosListaPresupuesto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosListaPresupuesto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VictoriaAppBundle:DatosListaPresupuesto:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing DatosListaPresupuesto entity.
     * @Security("has_role('ROLE_ADMIN')")
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


        $entity = $em->getRepository('VictoriaAppBundle:DatosListaPresupuesto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosListaPresupuesto entity.');
        }
        
        $idpre = $entity->getIdPresupuesto()->getIdPresupuesto();
        
        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VictoriaAppBundle:DatosListaPresupuesto:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'menu' => $menu,
            'idpre' => $idpre,
        ));
    }

    /**
    * Creates a form to edit a DatosListaPresupuesto entity.
    *
    * @param DatosListaPresupuesto $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(DatosListaPresupuesto $entity)
    {
        $form = $this->createForm(new DatosListaPresupuestoType(), $entity, array(
            'action' => $this->generateUrl('datoslistapresupuesto_update', array('id' => $entity->getIdLista())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing DatosListaPresupuesto entity.
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function updateAction(Request $request, $id)
    {
        /* Carga las variables de sesion del usuarios necesarias para dibujar menu y filtar la información */
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosListaPresupuesto')->find($id);
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosListaPresupuesto entity.');
        }
        $idpre = $entity->getIdPresupuesto()->getIdPresupuesto();
        
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('datoslistapresupuesto_list', array('id' => $idpre)));
        }

        return $this->render('VictoriaAppBundle:DatosListaPresupuesto:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'menu' => $menu,
            'idpre' => $idpre,
        ));
    }
    /**
     * Deletes a DatosListaPresupuesto entity.
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        //if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('VictoriaAppBundle:DatosListaPresupuesto')->find($id);
            
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DatosListaPresupuesto entity.');
            }
            $idpre = $entity->getIdPresupuesto()->getIdPresupuesto();

            $em->remove($entity);
            $em->flush();
        //}

        return $this->redirect($this->generateUrl('datoslistapresupuesto_list', array('id' => $idpre)));
    }

    /**
     * Creates a form to delete a DatosListaPresupuesto entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('datoslistapresupuesto_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
