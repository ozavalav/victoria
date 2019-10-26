<?php

namespace Victoria\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Victoria\AppBundle\Entity\DatosComentariosPresupuesto;
use Victoria\AppBundle\Form\DatosComentariosPresupuestoType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * DatosComentariosPresupuesto controller.
 *
 */
class DatosComentariosPresupuestoController extends Controller
{

    /**
     * Lists all DatosComentariosPresupuesto entities.
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
        
        $em = $this->getDoctrine()->getManager();
        
        /* Carga las variables de sesion del usuarios necesarias para dibujar menu y filtar la información */
        $session = $request->getSession();
        $menu = $session->get('_menu');
        $idCampana = $session->get('_id_campana');
        $idDistrito = $session->get('_id_distrito');
        
        /* Se define que información va a filtar segun el nivel de campana y distrito que tiene asignado*/
        $strWhere = $seg->filtrarConsulta($idCampana,$idDistrito);
        
        $query = "select p.id_presupuesto idpresupuesto, 
            p.tipo_egreso,
            e.descripcion tipoegreso,
            p.id_actividad_egreso,
            case 
            when p.fuente_egreso = 1 then 'Propio'
            when p.fuente_egreso = 2 then 'Donado'
            when p.fuente_egreso = 3 then 'Otros'
            else 'ND' end fuenteegreso,
            p.descripcion,
            p.preparado_por,
            u.nombre_usuario preparadopor,
            p.aprobado_por,
            case when a.nombre_usuario is null then 'NA' else a.nombre_usuario end aprobadopor,
            p.estado,
            ep.descripcion estado,
            case when p.estado = 1 then c.totale else c.totalr end total
            from datos_presupuestos p
            join ad_tipo_egresos e on (e.id_tipo_egreso = p.tipo_egreso)
            join ad_user u on (u.id = p.preparado_por)
            left join ad_user a on (a.id = p.aprobado_por)
            join ad_estados_presupuesto ep on (ep.id_estado_presupuesto = p.estado)
            left join (select id_presupuesto, sum(cantidad * costo_unitario_estimado) totale, sum(cantidad * costo_unitario_real) totalr
from datos_lista_presupuesto
group by id_presupuesto) c on (c.id_presupuesto = p.id_presupuesto)
            %1\$s
            ";
        
//********        *** revisar el la presentacion de los datos de presupuesto para comentar, 
//********            segun los niveles de cada usuario ***
                
        $query = sprintf($query, $strWhere);
        $stmt = $em->getConnection()->prepare($query);
        //$stmt->bindValue('campana',$idCampana);
        //$stmt->bindValue('distrito',$idDistrito);
        $stmt->execute();
        $entities = $stmt->fetchAll();

        /* Preparo el formulario para agregar un nuevo comentario */
        $entity = new DatosComentariosPresupuesto();
        $form   = $this->createCreateForm($entity);
        
        return $this->render('VictoriaAppBundle:DatosComentariosPresupuesto:index.html.twig', array(
            'entities' => $entities,
            'menu' => $menu,
            'form' => $form->createView(),
        ));
    }
    
    /**
     * Creates a new DatosComentariosPresupuesto entity.
     *
     */
    public function createAction(Request $request)
    {
        $session = $request->getSession();
        $usuario = $session->get('_nombre_usuario'); //Usuario quien pone la notificación
        
        $entity = new DatosComentariosPresupuesto();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            /* Busco la entidad  del presupuesto y actualizo el campo comentario */
            $idpre = (int)$request->get('idpresupuesto');
            $entpre = $em->getRepository('VictoriaAppBundle:DatosPresupuestos')->find($idpre);
            $entity->setIdPresupuesto($entpre);
            $entity->setUsuario($usuario); // Usuario quien hacer el comentario
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('datoscomentariospresupuesto'));
        }

        return $this->redirect($this->generateUrl('datoscomentariospresupuesto'));
    }

    /**
     * Creates a form to create a DatosComentariosPresupuesto entity.
     *
     * @param DatosComentariosPresupuesto $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DatosComentariosPresupuesto $entity)
    {
        $form = $this->createForm(new DatosComentariosPresupuestoType(), $entity, array(
            'action' => $this->generateUrl('datoscomentariospresupuesto_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new DatosComentariosPresupuesto entity.
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newAction()
    {
        $entity = new DatosComentariosPresupuesto();
        $form   = $this->createCreateForm($entity);

        return $this->render('VictoriaAppBundle:DatosComentariosPresupuesto:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a DatosComentariosPresupuesto entity.
     *
     */
    public function showAction(Request $request, $id)
    {
        /* Carga las variables de sesion del usuarios necesarias para dibujar menu y filtar la información */
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosPresupuestos')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosComentariosPresupuesto entity.');
        }

        $entitycom = $em->getRepository('VictoriaAppBundle:DatosComentariosPresupuesto')->findBy(array('idPresupuesto' => $id));

        return $this->render('VictoriaAppBundle:DatosComentariosPresupuesto:show.html.twig', array(
            'entity' => $entity,
            'comentarios' => $entitycom,          
            'menu' => $menu,
        ));
    }

    /**
     * Displays a form to edit an existing DatosComentariosPresupuesto entity.
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
        
        $em = $this->getDoctrine()->getManager();
        
        /* Carga las variables de sesion del usuarios necesarias para dibujar menu y filtar la información */
        $session = $request->getSession();
        $menu = $session->get('_menu');

        $entity = $em->getRepository('VictoriaAppBundle:DatosComentariosPresupuesto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosComentariosPresupuesto entity.');
        }

        $editForm = $this->createEditForm($entity);

        return $this->render('VictoriaAppBundle:DatosComentariosPresupuesto:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'menu' => $menu,
            
        ));
    }

    /**
    * Creates a form to edit a DatosComentariosPresupuesto entity.
    *
    * @param DatosComentariosPresupuesto $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(DatosComentariosPresupuesto $entity)
    {
        $form = $this->createForm(new DatosComentariosPresupuestoType(), $entity, array(
            'action' => $this->generateUrl('datoscomentariospresupuesto_update', array('id' => $entity->getIdComentario())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing DatosComentariosPresupuesto entity.
     * @Security("has_role('ROLE_ADMIN')") 
     */
    public function updateAction(Request $request, $id)
    {
        /* Carga las variables de sesion del usuarios necesarias para dibujar menu y filtar la información */
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosComentariosPresupuesto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosComentariosPresupuesto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('datoscomentariospresupuesto'));
        }

        return $this->render('VictoriaAppBundle:DatosComentariosPresupuesto:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'menu' => $menu,
        ));
    }
    /**
     * Deletes a DatosComentariosPresupuesto entity.
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        //if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('VictoriaAppBundle:DatosComentariosPresupuesto')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DatosComentariosPresupuesto entity.');
            }

            $em->remove($entity);
            $em->flush();
        //}

        return $this->redirect($this->generateUrl('datoscomentariospresupuesto'));
    }

    /**
     * Creates a form to delete a DatosComentariosPresupuesto entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('datoscomentariospresupuesto_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
