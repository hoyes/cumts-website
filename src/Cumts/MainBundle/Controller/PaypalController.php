<?php

namespace Cumts\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Orderly\PayPalIpnBundle\Ipn;
use Symfony\Component\HttpFoundation\Response;

use Cumts\MainBundle\Entity\Product;
use Cumts\MainBundle\Entity\Member;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Cumts\MainBundle\Entity\Transaction;

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

            if ($this->paypal_ipn->getOrderStatus() == Ipn::PAID) {
                // And we save the order now (persist and extract are separate because you might only want to persist the order in certain circumstances).
                $this->paypal_ipn->saveOrder();
                $order = $this->paypal_ipn->getOrder();
                $items = $this->paypal_ipn->getOrderItems();
                foreach ($items as $item) {
                    if ($item->getItemNumber() == -1) {
                        $this->handleMembership($order, $item);
                    }
                    else {
                        $this->handleSale($order, $item);
                    }
                }
            }

            else if ($this->paypal_ipn->getOrderStatus() == Ipn::REJECTED) {
                $message = \Swift_Message::newInstance()
                    ->setSubject('Cambridge University Musical Theatre Society - payment failed')
                    ->setFrom('webmaster@cumts.co.uk', 'Cambridge University Musical Theatre Society')
                    ->setTo($order->getPayerEmail(), $order->getFirstName().' '.$order->getLastName())
                    ->setCc('webmaster@cumts.co.uk', 'Cambridge University Musical Theatre Society')
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

    private function handleSale($order, $item)
    {
        $em = $this->getDoctrine()->getManager();
        $product_repo = $em->getRepository('CumtsMainBundle:Product');
        $product_repo->subtractItems($item->getItemNumber(), $item->getQuantity());
        $product = $product_repo->findOneById($order->getItemNumber());
        $member = $em->getRepository('CumtsMainBundle:Member')->findOneById($order->getCustom());
        // Now let's check what the payment status is and act accordingly
        if ($product) {
            $transaction = new Transaction();
            $transaction->setMember($member)
                ->setMemberName($order->getPayerEmail())
                ->setPaypalId($order->getPayerId())
                ->setPrice($item->getMcGross())
                ->setQuantity($item->getQuantity())
                ->setProduct($product)
                ->setProductName($product->getName());
            $em->persist($transaction);
            $em->flush();

            if ($product->getNumberAvailable() < 0) {
                $this->handleSoldOut($order, $item, $product, $member);
            }
            else {
                //preparing message
                $message = \Swift_Message::newInstance()
                    ->setSubject('Cambridge University Musical Theatre Society order confirmation')
                    ->setFrom('webmasterp@cumts.co.uk', 'Cambridge University Musical Theatre Society')
                    ->setTo($member->getEmail(), $member->getFullName())
                    ->setBcc($product->getContactEmail(), 'Cambridge University Musical Theatre Society')
                    ->setBody($this->renderView('CumtsMainBundle:Emails:order_sold_out.html.twig',
                    // Prepare the variables to populate the email template:
                    array('order' => $order,
                        'item' => $item,
                        'member' => $member,
                    ), 'text/plain'))
                ;
                //send message
                $this->get('mailer')->send($message);
            }
        }
    }

    private function handleSoldOut($order, $item, $product, $member)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('Cambridge University Musical Theatre Society - sold out')
            ->setFrom('membership@cumts.co.uk', 'Cambridge University Musical Theatre Society')
            ->setTo($order->getPayerEmail(), $order->getFirstName().' '.$order->getLastName())
            ->setCc($product->getContactEmail(), 'Cambridge University Musical Theatre Society')
            ->setBody($this->renderView('CumtsMainBundle:Emails:order_failed.html.twig',
            // Prepare the variables to populate the email template:
            array('order' => $order,
            ), 'text/plain'))
        ;
        //send message
        $this->get('mailer')->send($message);
    }

    private function handleMembership($order, $item)
    {
        $em = $this->getDoctrine()->getManager();
        $member = $em->getRepository('CumtsMainBundle:Member')->findOneById($order->getCustom());
        // Now let's check what the payment status is and act accordingly
        if ($member) {
            $member->setPaid(true);
            $em->flush();

            //preparing message
            $message = \Swift_Message::newInstance()
                ->setSubject('Cambridge University Musical Theatre Society membership confirmation')
                ->setFrom('membership@cumts.co.uk', 'Cambridge University Musical Theatre Society')
                ->setTo($member->getEmail(), $member->getFullName())
                ->setBcc('membership@cumts.co.uk', 'Cambridge University Musical Theatre Society')
                ->setBody($this->renderView('CumtsMainBundle:Emails:membership_confirmation.html.twig',
                // Prepare the variables to populate the email template:
                array('order' => $order,
                    'member' => $member,
                ), 'text/plain'))
            ;
            //send message
            $this->get('mailer')->send($message);
        }
    }

    public function initAction($id)
    {
        $product_repo = $this->getDoctrine()->getRepository('CumtsMainBundle:Product');
        $product = $product_repo->findOneById($id);
        if (!$product) {
            throw $this->createNotFoundException('Invalid product id');
        }
        if ($product->getNumberAvailable() <= 0) {
            return $this->render('CumtsMainBundle:Paypal:sold-out.html.twig', array(
                'product' => $product,
            ));
        }

        if ((($product->getRequiresMembership() || $product->getMembersPrice())
                    && !$this->getUser() instanceof Member)
                    || $product->getMaxQuantity() > 1) {
            return $this->render('CumtsMainBundle:Paypal:index.html.twig', array(
                'product' => $product,
            ));
        }

        return $this->forward('CumtsMainBundle:Paypal:redirect', array('id' => $id));
    }

    public function redirectAction($id)
    {
        $request = $this->getRequest();
        $product_repo = $this->getDoctrine()->getRepository('CumtsMainBundle:Product');
        $product = $product_repo->findOneById($id);
        if (!$product) {
            throw $this->createNotFoundException('Invalid product id');
        }
        if ($product->getNumberAvailable() <= 0) {
            return $this->render('CumtsMainBundle:Paypal:sold-out.html.twig', array(
                'product' => $product,
            ));
        }

        if ($request->query->has('membership')) {
            $membership = $request->get('membership');
        }
        else {
            $membership = null;
        }

        if (($product->getRequiresMembership() || $membership == 'check') && !$this->getUser()) {
            if ($request->query->has('quantity')) {
                $this->getRequest()->getSession()->set($product->getId().'_quantity', $request->get('quantity'));
            }
            throw new AuthenticationException('Checking CUMTS membership status');
        }
        elseif (!$this->getUser() && $membership == 'check') {
            return $this->render('CumtsMainBundle:Paypal:index.html.twig', array(
                'product' => $product,
            ));
        }

        if ($request->query->has('quantity')) {
            $quantity = $request->get('quantity');
        }
        else {
            if ($request->getSession()->has($product->getId().'_quantity')) {
                $quantity = $request->getSession()->get($product->getId().'_quantity');
            }
            else {
                $quantity = 1;
            }
        }
        if ($quantity > $product->getMaxQuantity()) $quantity = $product->getMaxQuantity();
        if ($quantity < 1) $quantity = 1;

        if (false && $this->get('kernel')->getEnvironment() == 'dev') {
            $url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
        }
        else {
            $url = "https://www.paypal.com/cgi-bin/webscr";
        }
        $params = array(
            'cmd' => '_cart',
            'upload' => 1,
            'business' => 'paypal@cumts.co.uk',
            'cert_id' => 'DPNNN66MU7U52',
            'return' => $this->generateUrl('CumtsMainBundle_paypal_complete', array(), true),
            'cancel_return' => $this->generateUrl('CumtsMainBundle_homepage', array(), true),
            'currency_code' => 'GBP',
            'item_number_1' => $product->getId(),
            'item_name_1' => $product->getName(),
            'amount_1' => $product->getPrice(),
            'quantity_1' => $quantity,
        );
        if ($product->getMembersPrice() > 0 && ($this->getUser() instanceof Member || $membership == 'yes')) {
            $params['discount_amount_1'] = $product->getPrice() - $product->getMembersPrice();
        }

        if ($this->getUser() instanceof Member) {
            /** @var $user Member */
            $user = $this->getUser();
            $params['first_name'] = $user->getFirstName();
            $params['last_name'] = $user->getLastName();
            $params['email'] = $user->getEmail();
            $params['custom'] = $user->getId();
        }
        elseif ($product->getRequiresMembership() || $membership == 'yes') {
            $params['amount_2'] = 10;
            $params['item_name_2'] = 'CUMTS Membership';
            $params['item_number_2'] = -1;
        }



        $data = $this->get('cumts_main.paypal')->encryptParams($params);

        $params = array(
            'cmd' => '_s-xclick',
            'encrypted' => $data,
        );

        $url .= '?'.http_build_query($params);
        return $this->redirect($url);
    }


}
