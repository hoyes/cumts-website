<?php

namespace Cumts\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Cumts\MainBundle\Entity\Show;
use Cumts\MainBundle\Entity\Photo;
use Hoyes\ImageManagerBundle\Entity\Image;

/**
 * Show controller.
 *
 */
class PhotoController extends Controller
{
    /**
     * Lists all Show entities.
     *
     */
    public function indexAction($page = 1, $limit = 50)
    {
        $em = $this->getDoctrine()->getManager();

        $paginator = $this->get('knp_paginator');
        $query = $em->getRepository('CumtsMainBundle:Show')->findBy(array(), array('start_at' => 'desc'));
        $entities = $paginator->paginate($query, $page, $limit);

        return $this->render('CumtsAdminBundle:Photo:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Finds and displays a Show entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CumtsMainBundle:Show')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Show entity.');
        }
        
        $session_id = urlencode($this->get('hoyes_image_manager.encryptor')->encrypt(session_id()));

        return $this->render('CumtsAdminBundle:Photo:show.html.twig', array(
            'entity'      => $entity,
            'session_id' => $session_id,
        ));
    }

    public function addAction($id)
    {
        $image_id = $this->getRequest()->query->get('image_id');    
        $img = $this->getDoctrine()->getRepository('HoyesImageManagerBundle:Image')->find($image_id);
        $show = $this->getDoctrine()->getRepository('CumtsMainBundle:Show')->find($id);
        if (!$img || !$show) return new Response();
        
        $p = new Photo;
        $p->setImage($img);
        $p->setShow($show);
        $em = $this->getDoctrine()->getManager();
        $em->persist($p);
        $em->flush();
        
        $data = array('photo_id' => $p->getId());
        return new Response(json_encode($data),200,array('Content-Type'=>'application/json'));
    }
    
    public function deleteAction($id)
    {
        $image_id = $this->getRequest()->query->get('image_id');    
        $img = $this->getDoctrine()->getRepository('CumtsMainBundle:Photo')->find($image_id);

        if (!$img) return new Response();
        
        $em = $this->getDoctrine()->getManager();
        $em->remove($img);
        $em->flush();
        
        $data = array('result' => 'success');
        return new Response(json_encode($data),200,array('Content-Type'=>'application/json'));
    }
}
