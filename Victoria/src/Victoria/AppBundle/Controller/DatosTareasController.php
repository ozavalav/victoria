<?php

namespace Victoria\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Victoria\AppBundle\Entity\DatosTareas;
use Victoria\AppBundle\Form\DatosTareasType;

/**
 * DatosTareas controller.
 *
 */
class DatosTareasController extends Controller
{

    /**
     * Lists all DatosTareas entities.
     *
     */
    public function indexAction(Request $request)
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


        $entities = $em->getRepository('VictoriaAppBundle:DatosTareas')->findBy(
                array(),
                array('idTarea' => 'ASC')
                );
        $entitiesEventos = $em->getRepository('VictoriaAppBundle:DatosEventos')->findAll();


                /* Preparo el formulario para agregar nuevo item */
        $entity = new DatosTareas();
        $form   = $this->createCreateForm($entity);
        
        
            $usr= $this->get('security.context')->getToken()->getUser();
            $usuario = $usr->getUsername();
        

        return $this->render('VictoriaAppBundle:DatosTareas:index.html.twig', array(
            'entities' => $entities,
            'entitiesEventos' => $entitiesEventos,
            'form' => $form->createView(),
            'form2' => $form->createView(),
            'menu' => $menu,
            'Usuario' => $usuario,
            ));
    }
    

    /**
     * Creates a new DatosTareas entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new DatosTareas();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();            
            
             

            
            $usr= $this->get('security.context')->getToken()->getUser();
            $usuario = $usr->getUsername();
            $fecha = new \DateTime("now");
            $entity->setProgreso(0);

            $entity->setUsuarioCreacion($usuario);
            $entity->setUsuarioUltimaModificacion($usuario);
            $entity->setFechaCreacion($fecha);
            $entity->setFechaUltimaModificacion($fecha);

            
            
                        
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('datostareas'));
        }

        return $this->render('VictoriaAppBundle:DatosTareas:new.html.twig');
    }

    /**
     * Creates a form to create a DatosTareas entity.
     *
     * @param DatosTareas $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DatosTareas $entity)
    {
        $form = $this->createForm(new DatosTareasType(), $entity, array(
            'action' => $this->generateUrl('datostareas_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new DatosTareas entity.
     *
     */
    public function newAction(Request $request)
    {
        
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        $entity = new DatosTareas();
        $form   = $this->createCreateForm($entity);

        return $this->render('VictoriaAppBundle:DatosTareas:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'menu' => $menu,
        ));
    }

    /**
     * Finds and displays a DatosTareas entity.
     *
     */
    public function showAction(Request $request, $id)
    {
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosTareas')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosTareas entity.');
        }
        $ideve = $entity->getIdEventos()->getIdEventos();


        return $this->render('VictoriaAppBundle:DatosTareas:show.html.twig', array(
            'entity'      => $entity,
            'menu' => $menu,
            'ideve' => $ideve,

        ));
    }

    /**
     * Displays a form to edit an existing DatosTareas entity.
     *
     */
    public function editAction(Request $request, $id)
    {
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosTareas')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosTareas entity.');
        }

        

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);
        
        $ideve = $entity->getIdEventos()->getIdEventos();

        return $this->render('VictoriaAppBundle:DatosTareas:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'menu' => $menu,
            'ideve' => $ideve,
            'delete_form' => $deleteForm->createView(),


        ));
    }

    
    
        public function editmodalAction(Request $request, $id)
    {
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosTareas')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosTareas entity.');
        }

        

        $editForm = $this->createEditmodalForm($entity);
        $deleteForm = $this->createDeleteForm($id);
        
        $ideve = $entity->getIdEventos()->getIdEventos();

        return $this->render('VictoriaAppBundle:DatosTareas:editmodal.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'menu' => $menu,
            'delete_form' => $deleteForm->createView(),


        ));
    }
    /**
    * Creates a form to edit a DatosTareas entity.
    *
    * @param DatosTareas $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(DatosTareas $entity)
    {
        $form = $this->createForm(new DatosTareasType(), $entity, array(
            'action' => $this->generateUrl('datostareas_update', array('id' => $entity->getIdTarea())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Editar'));

        return $form;
    }
    
        private function createEditmodalForm(DatosTareas $entity)
    {
        $form = $this->createForm(new DatosTareasType(), $entity, array(
            'action' => $this->generateUrl('datostareas_updatemodal', array('id' => $entity->getIdTarea())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Editar'));

        return $form;
    }
    /**
     * Edits an existing DatosTareas entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosTareas')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosTareas entity.');
        }

        $actualUsuarioCreacion = $entity->getUsuarioCreacion();
        $actualFechaCreacion = $entity->getFechaCreacion();
        //$actualIdEvento = $entity->getIdEventos();
        $actualprogreso = $entity->getprogreso();

        
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            
            $usr= $this->get('security.context')->getToken()->getUser();
            $usuario = $usr->getUsername();
            $fecha = new \DateTime("now");
           // $entity->setIdEventos($actualIdEvento);
            $entity->setProgreso($actualprogreso);
            $entity->setUsuarioCreacion($actualUsuarioCreacion);
            $entity->setUsuarioUltimaModificacion($usuario);
            $entity->setFechaCreacion($actualFechaCreacion);
            $entity->setFechaUltimaModificacion($fecha);          
            
            
            
            
            $em->flush();

            return $this->redirect($this->generateUrl('datostareas_edit', array('id' => $id)));
        }

        return $this->render('VictoriaAppBundle:DatosTareas:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'menu' => $menu,
        ));
    }
    
    
    //Action de edit para el responsable de la tarea
        public function updatemodalAction(Request $request, $id)
    {
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosTareas')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosTareas entity.');
        }

        $actualUsuarioCreacion = $entity->getUsuarioCreacion();
        $actualFechaCreacion = $entity->getFechaCreacion();
        //$actualIdEvento = $entity->getIdEventos();
        $actualTitulo = $entity->getTitulo();
        $actualDescripcion = $entity->getDescripcion();
        $actualEvento = $entity->getidEventos();
        $actualResponsable = $entity->getidResponsable();   
        $actualEstado = $entity->getidEstado();
        
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            
            $usr= $this->get('security.context')->getToken()->getUser();
            $usuario = $usr->getUsername();
            $fecha = new \DateTime("now");
           // $entity->setIdEventos($actualIdEvento);
            
            $entity->setTitulo($actualTitulo);
            $entity->setDescripcion($actualDescripcion);
            $entity->setidEventos($actualEvento);
            $entity->setidResponsable($actualResponsable);
            $entity->setidEstado($actualEstado);
            $entity->setUsuarioCreacion($actualUsuarioCreacion);
            $entity->setUsuarioUltimaModificacion($usuario);
            $entity->setFechaCreacion($actualFechaCreacion);
            $entity->setFechaUltimaModificacion($fecha);          
            
            
            
            
            $em->flush();

            return $this->redirect($this->generateUrl('datostareas'));
        }

        return $this->render('VictoriaAppBundle:DatosTareas:editmodal.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'menu' => $menu,
        ));
    }
    
    /**
     * Deletes a DatosTareas entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $entity = $em->getRepository('VictoriaAppBundle:DatosTareas')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DatosTareas entity.');
            }

            $em->remove($entity);
            $em->flush();
        }
        
           $ideve = (int)$request->get('ideventos');
            
        return $this->redirect($this->generateUrl('datostareas_list', array('id' => $ideve)));
    }

    /**
     * Creates a form to delete a DatosTareas entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        
        
        
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('datostareas_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
