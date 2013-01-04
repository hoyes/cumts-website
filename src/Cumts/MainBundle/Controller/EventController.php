<?php

namespace Cumts\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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

    /**
     * Finds and displays a Event entity.
     *
     */
    public function showAction($slug)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CumtsMainBundle:Event')->findOneBySlug($slug);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Event entity.');
        }

        return $this->render('CumtsMainBundle:Event:show.html.twig', array(
            'entity'      => $entity,
        ));
    }

}
