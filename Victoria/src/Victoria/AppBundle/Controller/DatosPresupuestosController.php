<?php

namespace Victoria\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Victoria\AppBundle\Entity\DatosPresupuestos;
use Victoria\AppBundle\Form\DatosPresupuestosType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * DatosPresupuestos controller.
 *
 */
class DatosPresupuestosController extends Controller
{

    /**
     * Lists all DatosPresupuestos entities.
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
        $strWhere = $seg->fitrarConsulta($idCampana,$idDistrito);
        
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
        $query = sprintf($query, $strWhere);
        $stmt = $em->getConnection()->prepare($query);
        //$stmt->bindValue('campana',$idCampana);
        //$stmt->bindValue('distrito',$idDistrito);
        $stmt->execute();
        $entities = $stmt->fetchAll();

        return $this->render('VictoriaAppBundle:DatosPresupuestos:index.html.twig', array(
            'entities' => $entities,
            'menu' => $menu,
        ));
    }
    /**
     * Creates a new DatosPresupuestos entity.
     *
     */
    public function createAction(Request $request)
    {
        $session = $request->getSession();
        $menu = $session->get('_menu');
        $idUsr = $session->get('_id_usuario');
        
        $entity = new DatosPresupuestos();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            /*
             * Busco el estado en la tabla AdEstadoPresupuesto 
             * 1 = Elbaborado, 2 = Aprobado, 3 = Ejecutado, 4 = Cancelado, 9 = Rechazado
             * Para ponerlo como esado inicial del presupuesto.
             */
            $entest = $em->getRepository('VictoriaAppBundle:AdEstadosPresupuesto')->find(1);
            
            $entity->setPreparadoPor($idUsr);
            $entity->setEstado($entest); 
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('datospresupuestos_show', array('id' => $entity->getIdPresupuesto())));
        }

        return $this->render('VictoriaAppBundle:DatosPresupuestos:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'menu' => $menu,
        ));
    }

    /**
     * Creates a form to create a DatosPresupuestos entity.
     *
     * @param DatosPresupuestos $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DatosPresupuestos $entity)
    {
        $form = $this->createForm(new DatosPresupuestosType(), $entity, array(
            'action' => $this->generateUrl('datospresupuestos_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new DatosPresupuestos entity.
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newAction(Request $request)
    {
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        $entity = new DatosPresupuestos();
        $form   = $this->createCreateForm($entity);

        return $this->render('VictoriaAppBundle:DatosPresupuestos:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'menu' => $menu,
        ));
    }

    /**
     * Finds and displays a DatosPresupuestos entity.
     *
     */
    public function showAction(Request $request, $id)
    {
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        $em = $this->getDoctrine()->getManager();

        $query = " select p.id_presupuesto idpresupuesto, 
            p.tipo_egreso,
            e.descripcion tipoegreso,
            p.id_actividad_egreso idactividadegreso,
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
            case when p.estado = 1 then p.total_presupuesto_estimado else p.total_presupuesto_ejecutado end total
            from datos_presupuestos p
            join ad_tipo_egresos e on (e.id_tipo_egreso = p.tipo_egreso)
            join ad_user u on (u.id = p.preparado_por)
            left join ad_user a on (a.id = p.aprobado_por)
            join ad_estados_presupuesto ep on (ep.id_estado_presupuesto = p.estado)
            where id_presupuesto = :idpre ";
        //$query = sprintf($query, $strWhere);
        $stmt = $em->getConnection()->prepare($query);
        $stmt->bindValue('idpre',$id);
        //$stmt->bindValue('distrito',$idDistrito);
        $stmt->execute();
        $entity = $stmt->fetchAll();
        
        /* Incluir en este metodo el detalle de las tareas para visualizar 
         * toda la información en una sola pantalla.
         */
        
        // >> *aqui*
        

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosPresupuestos entity.');
        }

        //$deleteForm = $this->createDeleteForm($id);

        return $this->render('VictoriaAppBundle:DatosPresupuestos:show.html.twig', array(
            'entity'      => $entity[0],
            //'delete_form' => $deleteForm->createView(),
            'menu' => $menu,
        ));
    }

    /**
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

        $entity = $em->getRepository('VictoriaAppBundle:DatosPresupuestos')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosPresupuestos entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VictoriaAppBundle:DatosPresupuestos:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'menu' => $menu,
        ));
    }

    /**
    * Creates a form to edit a DatosPresupuestos entity.
    *
    * @param DatosPresupuestos $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(DatosPresupuestos $entity)
    {
        $form = $this->createForm(new DatosPresupuestosType(), $entity, array(
            'action' => $this->generateUrl('datospresupuestos_update', array('id' => $entity->getIdPresupuesto())),
            'method' => 'PUT',
        ));

        $form->add('estado', EntityType::class, array(
                'class' => 'VictoriaAppBundle:AdEstadosPresupuesto',
                'label' => 'Estado'
            ))->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing DatosPresupuestos entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $session = $request->getSession();
        $menu = $session->get('_menu');
        $idUsr = $session->get('_id_usuario');
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosPresupuestos')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosPresupuestos entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            
            /* Actualizo el campos Aprobado por, solo si el estado cambia a Aprobado */
            $estado = $entity->getEstado()->getIdEstadoPresupuesto();
            if($estado === 2) {
                $entity->setAprobadoPor($idUsr);
            }
            $em->flush();

            return $this->redirect($this->generateUrl('datospresupuestos_edit', array('id' => $id)));
        }

        return $this->render('VictoriaAppBundle:DatosPresupuestos:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'menu' => $menu,
        ));
    }
    /**
     * Deletes a DatosPresupuestos entity.
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('VictoriaAppBundle:DatosPresupuestos')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DatosPresupuestos entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('datospresupuestos'));
    }

    /**
     * Creates a form to delete a DatosPresupuestos entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('datospresupuestos_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
