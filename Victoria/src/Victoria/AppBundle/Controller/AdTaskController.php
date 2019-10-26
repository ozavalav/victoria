<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Victoria\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Core\SecurityContext;

use Symfony\Component\HttpFoundation\JsonResponse;

use Victoria\AppBundle\Entity\AppConst;



/**
 * Description of AdTaskController
 *
 * @author mfusuario
 */
class AdTaskController extends Controller {
    
     /**
     * Lists all AdTask entities.
     *
     */
    public function indexAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $session = $request->getSession();
        $menu = $session->get('_menu');
        
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('VictoriaAppBundle:AdTask')->findAll();

        return $this->render('VictoriaAppBundle:AdTask:index.html.twig', array(
            'entities' => $entities,
            'menu' => $menu,
        ));
    }
    
    
    
    
    
    }