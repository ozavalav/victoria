<?php

namespace Victoria\AppBundle\Controller;

use Victoria\AppBundle\Entity\AppConst;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class MenuController extends Controller
{
    public function indexAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        
        $usr= $this->get('security.context')->getToken()->getUser();
        
        $usuario = $usr->getUsername();
        
        
        $em = $this->getDoctrine()->getManager();
        $entityUser = $em->getRepository('VictoriaAppBundle:AdUser')->findBy(array('username' => $usuario, 'idEstado' => AppConst::ESTADO_GENERAL_ACTIVO));
        
        if (!$entityUser) {
            throw $this->createNotFoundException('VICTORIA: No es posible encontrar el usuario.');
        }
        $codDepartamento = $entityUser[0]->getCodDepartamento();
        $codMunicipio = $entityUser[0]->getCodMunicipio();
        $idComunidad = $entityUser[0]->getIdComunidad();
        $idEstructura = $entityUser[0]->getIdEstructura();
        $idCampana = $entityUser[0]->getIdCampana();
        $idDistrito = $entityUser[0]->getIdDistrito();
        $idUsuario = $entityUser[0]->getId();
        $nombreUsuario = $entityUser[0]->getNombreUsuario();
        
        $acceso = $entityUser[0]->getAcceso();
        
        $entDepto = $em->getRepository('VictoriaAppBundle:AdDepartamentos')->findBy(array('codDepartamento' => $codDepartamento));
        
        $nombreDepartamento = $entDepto[0]->getNombre();
        
        $entMuni = $em->getRepository('VictoriaAppBundle:AdMunicipios')->findBy(array('codMunicipio' => $codMunicipio));
        
        $nombreMunicipio = $entMuni[0]->getNombre();
        
        $entCampana = $em->getRepository('VictoriaAppBundle:DatosCampanasPoliticas')->findBy(array('idCampana' => $idCampana));
        
        $nombreCampana = $entCampana[0]->getNombre();
        
        $entDistrito = $em->getRepository('VictoriaAppBundle:DatosDistritos')->findBy(array('idDistrito' => $idDistrito));
        
        $nombreDistrito = $entDistrito[0]->getNombre();
        
        
        /*$entityCli = $em->getRepository('AppBundle:AdClinica')->findBy(array('idClinica' => $idClinica));
        if (!$entityCli) {
            throw $this->createNotFoundException('SIMEC: No es posible encontrar la Clínica.');
        }
        $nombreClinica = $entityCli[0]->getNombre();
        $nombrePropietario = $entityCli[0]->getPropietario(); 
        */
        $session = $request->getSession();
        $session->set('_cod_municipio', $codMunicipio);
        $session->set('_cod_departamento', $codDepartamento);
        $session->set('_id_comunidad', $idComunidad);
        $session->set('_id_estructura', $idEstructura);
        $session->set('_id_campana', $idCampana);
        $session->set('_id_distrito', $idDistrito);
        
        $session->set('_nombre_municipio', $nombreMunicipio);
        $session->set('_nombre_departamento', $nombreDepartamento);
        $session->set('_nombre_campana', $nombreCampana);
        $session->set('_nombre_distrito', $nombreDistrito);
        $session->set('_cuenta_usuario', $usuario);
        $session->set('_nombre_usuario', $nombreUsuario);
        $session->set('_id_usuario', $idUsuario);
        $session->set('_acceso', $acceso);
        
        /* Captura la variable periodo que fue selecionado en el Login esta variable se
         * estable por medio de Ajax en la patalla de login.html.twig
         */
        $periodo = $session->get('_periodo');
        
        /* [ ] Preparar los datos que seran presentados en la pagina principal
         *  */
        /*$query = "select 
            max(fecha_creacion) ultfecha, 
            count(*) totalenc,
            sum(case when estado = 1  then 1 else 0 end) encpen,
            sum(case when usuario_creacion = :usr then 1 else 0 end) encxusr 
            from datos_generales
            where cod_departamento = :dep and cod_municipio = :mun and periodo = :per ";
            $stmt = $em->getConnection()->prepare($query);
            $stmt->bindValue('dep',$codDepartamento);
            $stmt->bindValue('mun',$codMunicipio);
            $stmt->bindValue('usr',$usuario);
            $stmt->bindValue('per',$periodo);
            $stmt->execute();
            $dtgen = $stmt->fetchAll(); */
        
        
        /* Lectura de las Notificaciones que recibe el usuario las prepara 
         * para ser cargados en cada pagina se leen una cada vez al principio 
         * cuando el usuario ingresa a una opcion Las Notificaciones se muestran  
         * en la parte superior de la pantalla.
         */
        $query = "select row_number() over( order by fecha_enviado desc ) orden, numero_mensaje, estado, substring(mensaje,1,30) mensaje
from datos_notificaciones where id_usuario = :idusuario and estado = 1
order by fecha_enviado desc";
        //$query = sprintf($query, $codColg, $rngfechag);
        $stmt = $em->getConnection()->prepare($query);
        $stmt->bindValue('idusuario', $idUsuario);
        //$stmt->bindValue('distrito',$idDistrito);
        $stmt->execute();
        $entnot = $stmt->fetchAll();
        
        /* Obtiene las cantidades de personas asignada por comision de todas las campañas */
        $query = "select 
case 
 when c.id_estructura = 1 then 'A'
 when c.id_estructura = 2 then 'B'
 when c.id_estructura = 3 then 'C'   
end estructura,
count(*) comisiones, 
sum(case when p.nombres is not null then 1 else 0 end) asignadas
from 
ad_tipos_comision c left join datos_personas p on (c.id_tipo_comision = p.id_comision)
group by c.id_estructura
order by c.id_estructura";
        //$query = sprintf($query, $codColg, $rngfechag);
        $stmt = $em->getConnection()->prepare($query);
        //$stmt->bindValue('idusuario', $idUsuario);
        //$stmt->bindValue('distrito',$idDistrito);
        $stmt->execute();
        $entest = $stmt->fetchAll();
        
        /* Crea el menu segun los acceso que tiene el usuario 
         * y los graba como una variable de sesion para ser utilizado en cada carga de pagina
         */
        $strmenu = $this->forward('Victoria\AppBundle\Controller\ArbolMenuController::menuAction',['acceso' => $acceso ]);    
        $session->set('_menu',$strmenu->getContent());
        return $this->render('VictoriaAppBundle:Menu:index.html.twig', 
                array(
                    //'dtgen' => $dtgen[0], 
                    'menu' => $strmenu->getContent(),
                    'datosnoti' => $entnot,
                    'entest' => $entest,
                ));
    }
    
    public function menuAction()
    {
        return $this->render('AppBundle:Menu:menu.html.twig');
    }
}
