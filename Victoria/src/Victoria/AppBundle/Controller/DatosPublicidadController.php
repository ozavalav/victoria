<?php

namespace Victoria\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Victoria\AppBundle\Entity\DatosPublicidad;
use Victoria\AppBundle\Form\DatosPublicidadType;

use Victoria\AppBundle\Entity\DatosPresupuestos;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * DatosPublicidad controller.
 *
 */
class DatosPublicidadController extends Controller
{

    /**
     * Lists all DatosPublicidad entities.
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
        /* Obtiene las tareas que tiene el usuario */
        $enttar = $seg->obtenerTareas($idUsuario);
        
        /* Se define que información va a filtar segun el nivel de campana y distrito que tiene asignado*/
        $strWhere = $seg->filtrarConsulta($idCampana,$idDistrito);
        
        $query = "  SELECT      p.id_publicidad idpublicidad, cp.nombre campana, d.nombre distrito, tp.nombre tipopublicidad, p.descripcion, 
                                p.preparado_por preparadopor, p.estado, p.nombre_medio_publicidad nombremediopublicidad,
                                p.tipo_anuncio tipoanuncio, p.comprobante_pago comprobantepago
                    FROM 	datos_publicidad p 
                    JOIN 	datos_campanas_politicas cp on (p.id_campana = cp.id_campana)
                    JOIN 	datos_distritos d on (p.id_distrito = d.id_distrito)
                    JOIN	ad_tipos_publicidad tp on (p.tipo_publicidad = tp.id_publicidad)
                    %1\$s
            ";
        $query = sprintf($query, $strWhere);
        $stmt = $em->getConnection()->prepare($query);
        //$stmt->bindValue('campana',$idCampana);
        //$stmt->bindValue('distrito',$idDistrito);
        $stmt->execute();
        $entities = $stmt->fetchAll();
        $entity = new DatosPublicidad();
        $form   = $this->createCreateForm($entity);

        
        return $this->render('VictoriaAppBundle:DatosPublicidad:index.html.twig', array(
            'entities' => $entities,
            'form' => $form->createView(),
            'menu' => $menu,
            'datosnoti' => $entnot, 
            'datostar' => $enttar, 
        ));
    }
    /**
     * Creates a new DatosPublicidad entity.
     *
     */ 
    public function createAction(Request $request)
    {
        $session = $request->getSession();
        $menu = $session->get('_menu');
        $idUsr = $session->get('_id_usuario');
        
        $entity = new DatosPublicidad();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            /* Guarda los valores por defecto */
            $usr= $this->get('security.context')->getToken()->getUser();
            $usuario = $usr->getUsername();
            $fecha = new \DateTime("now");
            $entity->setUsuarioCreacion($usuario);
            $entity->setUsuarioUltimaModificacion($usuario);
            $entity->setFechaCreacion($fecha);
            $entity->setFechaUltimaModificacion($fecha);
            $entity->setEstado(1);
            $entity->setPreparadoPor(1);
            
            $em->persist($entity);
            
/********** Crear un registro para aprobacion de finanzas ********* /
 * 
 */         
            $entpre = new DatosPresupuestos();
            
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
            $entpre->setIdPresupuesto($newId);
            
            $entte = $em->getRepository('VictoriaAppBundle:AdTipoEgresos')->find(2); //campana publicitaria
            $entpre->setTipoEgreso($entte); //campaña publicitaria
            
            //$entpre->setFuenteEgreso(1); // fondos propios
            $entpre->setDescripcion($entity->getDescripcion());
            $entpre->setObjetivoEvento("Medio: " . $entity->getNombreMedioPublicidad() . " Tipo: " . $entity->getTipoAnuncio());
            $entpre->setIdCampana($entity->getIdCampana());
            $entpre->setIdDistrito($entity->getIdDistrito());
            
            /*
             * Busco el estado en la tabla AdEstadoPresupuesto 
             * 1 = Elbaborado, 2 = Aprobado, 3 = Ejecutado, 4 = Cancelado, 9 = Rechazado
             * Para ponerlo como esado inicial del presupuesto.
             */
            $entest = $em->getRepository('VictoriaAppBundle:AdEstadosPresupuesto')->find(1);
            
            $entpre->setPreparadoPor($idUsr);
            $entpre->setEstado($entest);
            
            $entcv = $em->getRepository('VictoriaAppBundle:DatosCentrosVotacion')->find(0);
            $entpre->setIdCv($entcv);
            
            $em->persist($entpre);
            
            $em->flush();

            return $this->redirect($this->generateUrl('datospublicidad_show', array('id' => $entity->getIdPublicidad())));
        }

        return $this->render('VictoriaAppBundle:DatosPublicidad:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'menu' => $menu,

        ));
    }

    /**
     * Creates a form to create a DatosPublicidad entity.
     *
     * @param DatosPublicidad $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DatosPublicidad $entity)
    {
        $form = $this->createForm(new DatosPublicidadType(), $entity, array(
            'action' => $this->generateUrl('datospublicidad_create'),
            'method' => 'POST',
        ));
//AQUIIIIIIIII
        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new DatosPublicidad entity.
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newAction(Request $request)
    {
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        $entity = new DatosPublicidad();
        $form   = $this->createCreateForm($entity);

        return $this->render('VictoriaAppBundle:DatosPublicidad:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'menu' => $menu,
        ));
    }

    /**
     * Finds and displays a DatosPublicidad entity.
     *
     */
    public function showAction(Request $request, $id)
    {
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        $em = $this->getDoctrine()->getManager();

        $query = " select       p.id_publicidad idpublicidad, 
                                cp.nombre campana, 
                                d.nombre distrito, 
                                tp.nombre tipopublicidad, 
                                p.descripcion, 
                                p.preparado_por preparadopor, 
                                p.estado, 
                                p.nombre_medio_publicidad nombremediopublicidad,
                                p.tipo_anuncio tipoanuncio, 
                                p.comprobante_pago comprobantepago,
                                p.fecha_creacion fechacreacion,
                                p.usuario_creacion usuariocreacion,
                                p.usuario_ultima_modificacion usuarioultimamodificacion,
                                p.fecha_ultima_modificacion fechaultimamodificacion
                    from 	datos_publicidad p 
                    join 	datos_campanas_politicas cp on (p.id_campana = cp.id_campana)
                    join 	datos_distritos d on (p.id_distrito = d.id_distrito)
                    join	ad_tipos_publicidad tp on (p.tipo_publicidad = tp.id_publicidad)
                    where       p.id_publicidad = :idpub ";
        //$query = sprintf($query, $strWhere);
        $stmt = $em->getConnection()->prepare($query);
        $stmt->bindValue('idpub',$id);
        //$stmt->bindValue('distrito',$idDistrito);
        $stmt->execute();
        $entity = $stmt->fetchAll();
        
        /* Incluir en este metodo el detalle de las tareas para visualizar 
         * toda la información en una sola pantalla.
         */
        
        // >> *aqui*
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosPublicidad entity.');
        }

        //$deleteForm = $this->createDeleteForm($id);

        return $this->render('VictoriaAppBundle:DatosPublicidad:show.html.twig', array(
            'entity'      => $entity[0],
            //'delete_form' => $deleteForm->createView(),
            'menu' => $menu,
        ));
    }

    /**
     * Displays a form to edit an existing DatosPublicidad entity.
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

        $entity = $em->getRepository('VictoriaAppBundle:DatosPublicidad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosPublicidad entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VictoriaAppBundle:DatosPublicidad:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'menu' => $menu,

        ));
    }

    /**
     * Displays a form to edit an existing DatosPublicidad entity.
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editdetalleAction(Request $request, $id)
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

        $entity = $em->getRepository('VictoriaAppBundle:DatosPublicidad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosPublicidad entity.');
        }

        $editForm = $this->createEditDetalleForm($entity);
        $deleteForm = $this->createDeleteForm($id);
        $idtipopublicidad = $entity->getTipoPublicidad()->getIdPublicidad();
        
        return $this->render('VictoriaAppBundle:DatosPublicidad:editDetalle.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'menu' => $menu,
            'idtipopublicidad' => $idtipopublicidad,

        ));
    }

    /**
    * Creates a form to edit a DatosPublicidad entity.
    *
    * @param DatosPublicidad $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(DatosPublicidad $entity)
    {
        $form = $this->createForm(new DatosPublicidadType(), $entity, array(
            'action' => $this->generateUrl('datospublicidad_update', array('id' => $entity->getIdPublicidad())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    
        private function createEditDetalleForm(DatosPublicidad $entity)
    {
        $form = $this->createForm(new DatosPublicidadType(), $entity, array(
            'action' => $this->generateUrl('datospublicidad_updatedetalle', array('id' => $entity->getIdPublicidad())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing DatosPublicidad entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosPublicidad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosPublicidad entity.');
        }
        
        $actualUsuarioCreacion = $entity->getUsuarioCreacion();
        $actualFechaCreacion = $entity->getFechaCreacion();
        
        $actualUsuarioUltimaModificacion = $entity->getUsuarioUltimaModificacion();
        $actualFechaModificacion = $entity->getFechaUltimaModificacion();
        
        
        
        $actualMeGusta = $entity->getMeGusta();
        $actualMeEncanta = $entity->getMeEncanta();
        $actualMeDivierte = $entity->getMeDivierte();
        $actualMeEntristece = $entity->getMeEntristece();
        $actualMeEnoja = $entity->getMeEnoja();
        $actualComentariosPositivos = $entity->getComentariosPositivos();
        $actualComentariosNegativos = $entity->getComentariosNegativos();
        $actualCompartidos = $entity->getCompartidos();


        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            
            $usr= $this->get('security.context')->getToken()->getUser();
            $usuario = $usr->getUsername();
            $fecha = new \DateTime("now");
            $entity->setUsuarioCreacion($actualUsuarioCreacion);
            $entity->setUsuarioUltimaModificacion($actualUsuarioUltimaModificacion);
            $entity->setFechaCreacion($actualFechaCreacion);
            $entity->setFechaUltimaModificacion($actualFechaModificacion);
            $entity->setEstado(1);
            $entity->setPreparadoPor(1);
            $entity->setMeGusta($actualMeGusta);
            $entity->setMeEncanta($actualMeEncanta);
            $entity->setMeDivierte($actualMeDivierte);
            $entity->setMeEntristece($actualMeEntristece);
            $entity->setMeEnoja($actualMeEnoja);
            $entity->setComentariosPositivos($actualComentariosPositivos);
            $entity->setComentariosNegativos($actualComentariosNegativos);
            $entity->setCompartidos($actualCompartidos);
            
    

            
            $em->flush();

            return $this->redirect($this->generateUrl('datospublicidad_edit', array('id' => $id)));
        }

        return $this->render('VictoriaAppBundle:DatosPublicidad:editDetalle.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'menu' => $menu,

        ));
    }
    
    /**
     * Edits an existing DatosPublicidad entity.
     *
     */
    public function updatedetalleAction(Request $request, $id)
    {
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VictoriaAppBundle:DatosPublicidad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DatosPublicidad entity.');
        }
        
        $actualUsuarioCreacion = $entity->getUsuarioCreacion();
        $actualFechaCreacion = $entity->getFechaCreacion();
        
        $actualUsuarioUltimaModificacion = $entity->getUsuarioUltimaModificacion();
        $actualFechaModificacion = $entity->getFechaUltimaModificacion();
        
        $actuaTipoPublicidad = $entity->getTipoPublicidad();
        $actualDescripcion = $entity->getDescripcion();
        $actualEstado = $entity->getEstado();
        $actualNombreMedioPublicidad = $entity->getNombreMedioPublicidad();
        $actualTipoAnuncio = $entity->getTipoAnuncio();
        $actualComprobantePago = $entity->getComprobantePago();
        $actualIdCampana = $entity->getIdCampana();
        $actualIdDistrito = $entity->getIdDistrito();

        $editForm = $this->createEditDetalleForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            
            $usr= $this->get('security.context')->getToken()->getUser();
            $usuario = $usr->getUsername();
            $fecha = new \DateTime("now");
        
            $entity->setTipoPublicidad($actuaTipoPublicidad);
            $entity->setDescripcion($actualDescripcion);
            $entity->setEstado($actualEstado);
            $entity->setNombreMedioPublicidad($actualNombreMedioPublicidad);
            $entity->setTipoAnuncio($actualTipoAnuncio);
            $entity->setComprobantePago($actualComprobantePago);
            $entity->setIdCampana($actualIdCampana);
            $entity->setIdDistrito($actualIdDistrito);

            
            $entity->setUsuarioCreacion($actualUsuarioCreacion);
            $entity->setUsuarioUltimaModificacion($actualUsuarioUltimaModificacion);
            $entity->setFechaCreacion($actualFechaCreacion);
            $entity->setFechaUltimaModificacion($actualFechaModificacion);
            $entity->setEstado(1);
            $entity->setPreparadoPor(1);
            
            $em->flush();

            return $this->redirect($this->generateUrl('datospublicidad_editdetalle', array('id' => $id)));
        }

        return $this->render('VictoriaAppBundle:DatosPublicidad:editDetalle.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'menu' => $menu,

        ));
    }
    /**
     * Deletes a DatosPublicidad entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('VictoriaAppBundle:DatosPublicidad')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DatosPublicidad entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('datospublicidad'));
    }

    /**
     * Creates a form to delete a DatosPublicidad entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('datospublicidad_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
