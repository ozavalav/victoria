<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Victoria\AppBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Description of Seguridad
 * Clase que es utilizada para verificar accesos de los usuarios del sistema
 * @author ozavala
 */
class Seguridad extends Controller {
    protected $em;
    protected $container;
    
    public function __construct(EntityManager $entityManager, Container $container)
    {
        $this->em = $entityManager;
        $this->container = $container;
    }
    
    /* Verifica si un usuario esta logeado */
    public function validarUsuario() {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        } else {
            return true;
        }
    }
    
    public function comprobarAcceso($ruta){
        
        $em = $this->getDoctrine()->getManager();
        
        /* Divido el string ruta */
        $rt = explode("_",$ruta);
        $ruta = $rt[0];
        
        /* Obtengo el usuario actual */
          $username = $this->get('security.context')->getToken()->getUser();
          $usuario = $username->getUsername();
          
        /* Buscar el usuario para sacar su id */
          $entusr = $em->getRepository('VictoriaAppBundle:AdUser')->findBy(array('username' => $usuario));
          $idacc = $entusr[0]->getAcceso(); //id de acceso
          
          /* con el id de usuario buscamos las opciones que su rol tiene asignada */
          $query = "select o.nombre from ad_acceso_grant g
            join ad_grant o on (o.objeto = g.objeto)
            where g.id_acceso = :acceso and o.nombre like '%1\$s%%'";
          $query = sprintf($query, $ruta);
          $stmt = $em->getConnection()->prepare($query);
          $stmt->bindValue('acceso',$idacc);
          $stmt->execute();
          $entacc = $stmt->fetchAll();
          
          if($entacc) {
              return true;
          } else {
              throw $this->createAccessDeniedException();
          }
    }
    
    public function filtrarConsulta($idCampana, $idDistrito) {
        $strWhere = ""; 
        if($idCampana === 0 and $idDistrito === 0 ) {
            $strWhere = "";
        } elseif ($idCampana !== 0 and $idDistrito === 0) {
            $strWhere = " where p.id_campana = ".$idCampana;
        } elseif ($idCampana === 0 and $idDistrito !== 0) {
            $strWhere = " where p.id_distrito = ".$idDistrito;
        } else {
            $strWhere = " where p.id_campana = ".$idCampana." and p.id_distrito = ".$idDistrito;
        }
        return $strWhere;
    }
    
    public function obtenerNotificaciones($idUsuario){
        /* Lectura de las Notificaciones que recibe el usuario las prepara 
         * para ser cargados en cada pagina se leen una cada vez al principio 
         * cuando el usuario ingresa a una opcion Las Notificaciones se muestran  
         * en la parte superior de la pantalla.
         */
        $em = $this->getDoctrine()->getManager();
        
        $query = "select row_number() over( order by fecha_enviado desc ) orden, numero_mensaje, estado, substring(mensaje,1,30) mensaje
from datos_notificaciones where id_usuario = :idusuario and estado = 1
order by fecha_enviado desc";
        //$query = sprintf($query, $codColg, $rngfechag);
        $stmt = $em->getConnection()->prepare($query);
        $stmt->bindValue('idusuario', $idUsuario);
        //$stmt->bindValue('distrito',$idDistrito);
        $stmt->execute();
        $entnot = $stmt->fetchAll();
        
        return $entnot;
    }
}
