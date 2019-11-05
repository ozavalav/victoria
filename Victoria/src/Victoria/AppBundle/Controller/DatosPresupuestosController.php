<?php

namespace Victoria\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Victoria\AppBundle\Entity\DatosPresupuestos;
use Victoria\AppBundle\Form\DatosPresupuestosType;
use Victoria\AppBundle\Entity\DatosNotificaciones;


use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

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
        $idUsuario = $session->get('_id_usuario');
        
         /* Obtiene las notificaciones que tiene el usuario */
        $entnot = $seg->obtenerNotificaciones($idUsuario);
        
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
        $query = sprintf($query, $strWhere);
        $stmt = $em->getConnection()->prepare($query);
        //$stmt->bindValue('campana',$idCampana);
        //$stmt->bindValue('distrito',$idDistrito);
        $stmt->execute();
        $entities = $stmt->fetchAll();

        return $this->render('VictoriaAppBundle:DatosPresupuestos:index.html.twig', array(
            'entities' => $entities,
            'menu' => $menu,
            'datosnoti' => $entnot,  
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
        $usuario = $session->get('_nombre_usuario');
        $seg = $this->container->get('victoria_app.vicseguridad');
        
        $entity = new DatosPresupuestos();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            /* Generar el numero de secuencia para el id_presupuesto */
            try {
                $sequenceName = 'datos_presupuestos_id_presupuesto_seq';
                $dbConnection = $em->getConnection();
                $nextvalQuery = $dbConnection->getDatabasePlatform()->getSequenceNextValSQL($sequenceName);
                $newId = (int)$dbConnection->fetchColumn($nextvalQuery);

            } catch (\Exception $e) {
                $this->addFlash('error', $e->getMessage());
                //throw $e;
            }
            $entity->setIdPresupuesto($newId);
            /*
             * Busco el estado en la tabla AdEstadoPresupuesto 
             * 1 = Elbaborado, 2 = Aprobado, 3 = Ejecutado, 4 = Cancelado, 9 = Rechazado
             * Para ponerlo como esado inicial del presupuesto.
             */
            $entest = $em->getRepository('VictoriaAppBundle:AdEstadosPresupuesto')->find(1);
            
            $entity->setPreparadoPor($idUsr);
            $entity->setEstado($entest); 
            
            $fechatmp = $entity->getFechaEvento();            
            $fecha = new \DateTime($fechatmp);
            $entity->setFechaEvento($fecha);
            
            $em->persist($entity);
            
/* -----------------------------------------------------------------------
 * PROCESO PARA NOTIFICAR EL NUEVO PRESUPUESTO A LOS USUARIOS INTERESADOS
 * -----------------------------------------------------------------------
 */            
            /* Guarda el registro para las notificaciones a los usuarios seleccionados */
            $usuarios = $request->get('personas');
            
            /* Si todos se selecionaron todos los usuarios */
            if($usuarios[0] == 0) {
                /* Se define que información va a filtar segun el nivel de campana y distrito que tiene asignado*/
        $strWhere = $seg->filtrarConsulta($entity->getIdCampana()->getIdCampana(),$entity->getIdDistrito()->getIdDistrito());
        
        $query = "select p.id from ad_user p %1\$s";
        $query = sprintf($query, $strWhere);
        $stmt = $em->getConnection()->prepare($query);
        $stmt->execute();
        $usuarios = $stmt->fetchAll();
            }
            
            foreach($usuarios as $usr) {
                $noti = new DatosNotificaciones();
                $noti->setIdCampana($entity->getIdCampana());
                $noti->setIdDistrito($entity->getIdDistrito());
                
                /*Busca el usuario para agregarlo a la entidad de Notificaciones */
                $etusr = $em->getRepository('VictoriaAppBundle:AdUser')->find($usr);
                
                /* Generar el numero de secuencia para el numero de mensaje
             * este es un numero unico para todos los usuarios que reciben el mensaje 
             */
            try {
                $sequenceName = 'datos_notificaciones_numero_mensaje_seq';
                $dbConnection = $em->getConnection();
                $nextvalQuery = $dbConnection->getDatabasePlatform()->getSequenceNextValSQL($sequenceName);
                $nummsg = (int)$dbConnection->fetchColumn($nextvalQuery);

            } catch (\Exception $e) {
                $this->addFlash('error', $e->getMessage());
            }
                $noti->setNumeroMensaje($nummsg); 
                $noti->setIdUsuario($etusr);
                $noti->setMensaje('Revision del presupuesto para la actividad: '.$entity->getDescripcion());
                $noti->setFechaEnviado($fecha);
                $noti->setEstado(1); // 1= Enviando; 2=Recibido; 3=Eliminado
                $noti->setIdEvento($newId); // Se le asigna el mismo id generado para la entidad DatosPresupuesto
                $noti->setUsuario($usuario);
                $em->persist($noti);
                
            }
            
            
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
        
        
        $form->add('submit', 'submit', array('label' => 'Create'))
                ->add('fechaEvento',TextType::class,array('label'=>'Fecha'))
                /*->add('personas', ChoiceType::class, 
                        array('choices' => array('Todos' => 0, 'Ninguno'=> 999),
                        'mapped' => false,    
                        'choices_as_values' => true,
                        'multiple' => true,
                        'label' => 'Personas',
                        'attr' => array('size' => '10'),    
                ))*/;

        return $form;
    }

    /**
     * Displays a form to create a new DatosPresupuestos entity.
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
        
        /* Detalle de las actividades del presupuesto */
        $query = "select descripcion, round(cantidad * costo_unitario_estimado,2)  total
from datos_lista_presupuesto
where id_presupuesto = :idpre";
        //$query = sprintf($query, $strWhere);
        $stmt = $em->getConnection()->prepare($query);
        $stmt->bindValue('idpre',$id);
        //$stmt->bindValue('distrito',$idDistrito);
        $stmt->execute();
        $entdetalle = $stmt->fetchAll();
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosPresupuestos entity.');
        }

        //$deleteForm = $this->createDeleteForm($id);

        return $this->render('VictoriaAppBundle:DatosPresupuestos:show.html.twig', array(
            'entity'      => $entity[0],
            'detalle' => $entdetalle,
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
