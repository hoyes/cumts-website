<?php

namespace Cumts\AdminBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Orderly\PayPalIpnBundle\Entity\IpnOrders;

/**
 * IpnOrders controller.
 *
 */
class PaypalController extends Controller
{
    /**
     * Lists all IpnOrders entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('OrderlyPayPalIpnBundle:IpnOrders')->findAll();

        return $this->render('CumtsAdminBundle:Paypal:orders-index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Finds and displays a IpnOrders entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OrderlyPayPalIpnBundle:IpnOrders')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find IpnOrders entity.');
        }

        return $this->render('CumtsAdminBundle:Paypal:orders-show.html.twig', array(
            'entity'      => $entity,
        ));
    }

}
