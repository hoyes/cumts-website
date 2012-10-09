<?php

namespace Cumts\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Orderly\PayPalIpnBundle\Ipn;
use Symfony\Component\HttpFoundation\Response;

/**
 * Paypal controller.
 *
 */
class PaypalController extends Controller
{

    public $paypal_ipn;

    public function ipnAction()
    {
        //getting ipn service registered in container
        $this->paypal_ipn = $this->get('orderly_pay_pal_ipn');

	$logger = $this->get('logger');
        //validate ipn (generating response on PayPal IPN request)
        if ($this->paypal_ipn->validateIPN())
        {
            // Succeeded, now let's extract the order
            $this->paypal_ipn->extractOrder();

            // And we save the order now (persist and extract are separate because you might only want to persist the order in certain circumstances).
            $this->paypal_ipn->saveOrder();
            $order = $this->paypal_ipn->getOrder();
            $em = $this->getDoctrine()->getEntityManager();
            $member = $em->getRepository('CumtsMainBundle:Member')->findOneById($order->getCustom());
	    // Now let's check what the payment status is and act accordingly
            if ($this->paypal_ipn->getOrderStatus() == Ipn::PAID && $member)
            {
	        $member->setPaid(true);
	        $em->flush();
                
                //preparing message
                $message = \Swift_Message::newInstance()
                    ->setSubject('Cambridge Musical Theatre Society membership confirmation')
                    ->setFrom('membership@cumts.co.uk', 'Cambridge University Musical Theatre Society')
                    ->setTo($member->getEmail(), $member->getFullName())
                    ->setBcc('membership@cumts.co.uk', 'Cambridge University Musical Theatre Society')
                    ->setBody($this->renderView('CumtsMainBundle:Emails:order_confirmation.html.twig',
                            // Prepare the variables to populate the email template:
                            array('order' => $order,
                                'member' => $member,
                            ), 'text/plain'))
                ;
                //send message
                $this->get('mailer')->send($message);
            }
            else if ($this->paypal_ipn->getOrderStatus() == Ipn::REJECTED) {
                $message = \Swift_Message::newInstance()
                    ->setSubject('Cambridge Musical Theatre Society - payment failed')
                    ->setFrom('membership@cumts.co.uk', 'Cambridge University Musical Theatre Society')
                    ->setTo($order->getPayerEmail(), $order->getFirstName().' '.$order->getLastName())
                    ->setCc('membership@cumts.co.uk', 'Cambridge University Musical Theatre Society')
                    ->setBody($this->renderView('CumtsMainBundle:Emails:order_failed.html.twig',
                            // Prepare the variables to populate the email template:
                            array('order' => $order,
                            ), 'text/plain'))
                ;
                //send message
                $this->get('mailer')->send($message);                
            }
        }
        else // Just redirect to the root URL
        {
            return $this->redirect('/');
        }

        $response = new Response();
        $response->setStatusCode(200);
        
        return $response;
    }


}
