<?php

namespace Cumts\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Cumts\MainBundle\Entity\News;

/**
 * News controller.
 *
 */
class NewsController extends Controller
{
    /**
     * Lists all News entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('CumtsMainBundle:News')->findAll();

        return $this->render('CumtsMainBundle:News:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Finds and displays a News entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('CumtsMainBundle:News')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find News entity.');
        }

        return $this->render('CumtsMainBundle:News:show.html.twig', array(
            'entity'      => $entity,
        ));
    }

}
