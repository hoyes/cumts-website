<?php

namespace Cumts\MainBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Cumts\MainBundle\Entity\Show;
use Cumts\MainBundle\Form\ShowType;

/**
 * Show controller.
 *
 */
class ShowController extends Controller
{
    /**
     * Lists all Show entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CumtsMainBundle:Show')->findAll();

        return $this->render('CumtsMainBundle:Show:index.html.twig', array(
            'shows' => $shows,
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

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CumtsMainBundle:Show:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

}
