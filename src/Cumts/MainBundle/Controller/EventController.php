<?php

namespace Cumts\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Pagerfanta\Pagerfanta,
    Pagerfanta\Adapter\DoctrineORMAdapter,
    Pagerfanta\Exception\NotValidCurrentPageException;


use Cumts\MainBundle\Entity\Event;

/**
 * Event controller.
 *
 */
class EventController extends Controller
{
    /**
     * Lists all Event entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CumtsMainBundle:Event')->findUpcoming();

        return $this->render('CumtsMainBundle:Event:index.html.twig', array(
            'entities' => $entities
        ));
    }
    
    public function archiveAction($page)
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->getRepository('CumtsMainBundle:Event')->findArchiveQuery();
        $pagerfanta = new Pagerfanta(new DoctrineORMAdapter($query));
	$pagerfanta->setMaxPerPage(10);
	$pagerfanta->setCurrentPage($page);

        return $this->render('CumtsMainBundle:Event:archive.html.twig', array(
            'entities' => $pagerfanta
        ));
    }

    /**
     * Finds and displays a Event entity.
     *
     */
    public function showAction($slug)
    {
        $repo = $this->getDoctrine()->getRepository('CumtsMainBundle:Event');
        $entity = $repo->findOneBySlug($slug);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Event entity.');
        }
        
        return $this->render('CumtsMainBundle:Event:show.html.twig', array(
            'entity'      => $entity,
        ));
    }
    
    public function otherEventsAction($id = null)
    {
        $repo = $this->getDoctrine()->getRepository('CumtsMainBundle:Event');
        $other_events = $repo->getUpcoming(2, $id);
        
        return $this->render('CumtsMainBundle:Event:other_events.html.twig', array(
            'other_events' => $other_events,
        ));
    }

}
