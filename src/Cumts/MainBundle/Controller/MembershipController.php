<?php

namespace Cumts\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Cumts\MainBundle\Entity\Member;
use Cumts\MainBundle\Form\Type\MemberType;

//require_once __DIR__.'/../../../../vendor/Ucam_Webauth/Ucam_Webauth.php';

class MembershipController extends Controller
{
    
    public function indexAction()
    {
        return $this->render('CumtsMainBundle:Membership:index.html.twig', array());
    }
    
    public function ravenAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
	$user = $this->get('security.context')->getToken()->getUser();
        $member = $em->getRepository('CumtsMainBundle:Member')->findOneBy(array('auth_id' => $user->getUsername()));
        if ($member) {
            if ($member->getPaid()) return $this->render('CumtsMainBundle:Membership:raven_success.html.twig', array('member' => $member, 'paid' => true));
            else return $this->forward("CumtsMainBundle:Membership:pay", array('auth_id'  => $user->getUsername()));
        }
        else {
            return $this->forward("CumtsMainBundle:Membership:join");
        }
    }
    
    public function payAction()
    {
	$auth_id = $this->get('security.context')->getToken()->getUser()->getUsername();
        $em = $this->getDoctrine()->getEntityManager();
        $member = $em->getRepository('CumtsMainBundle:Member')->findOneBy(array('auth_id' => $auth_id));
        
        if ($this->get('kernel')->getEnvironment() == 'dev') {
                $url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
                $button = "FATVTR3S2R5ZG";
        }
        else {
                $url = "https://www.paypal.com/cgi-bin/webscr";
                $button = "XCQN3ULLBR25W";
        }
        
        return $this->render('CumtsMainBundle:Membership:pay.html.twig', array('entity' => $member, 'url' => $url, 'button' => $button));
    }
    
    public function cancelAction()
    {
       return $this->redirect($this->generateUrl("CumtsMainBundle_membership"));
    }
    
    public function completeAction()
    {
	$auth_id = $this->get('security.context')->getToken()->getUser()->getUsername();
        $em = $this->getDoctrine()->getEntityManager();
        $member = $em->getRepository('CumtsMainBundle:Member')->findOneBy(array('auth_id' => $auth_id));
	if ($member && $auth_id) {
	        return $this->render('CumtsMainBundle:Membership:complete.html.twig', array('auth_id' => $auth_id, 'member' => $member));
	}
        else return $this->redirect($this->generateUrl("CumtsMainBundle_membership"));
    }
    
    public function joinAction()
    {
	$auth_id = $this->get('security.context')->getToken()->getUser()->getUsername();
        $request = $this->getRequest();
        $entity  = new Member();
                
        if ($auth_id) {
                $details = $this->get('cambridge_ldap')->lookup($auth_id);
                $entity->setFirstName($details['first_name']);
                $entity->setLastName($details['last_name']);
                $entity->setAuthId($auth_id);
                $entity->setCollege($details['college']);
                $entity->setEmail($details['email']);
                $entity->setJoinedAt(new \DateTime);
       		
		$entity->setLeavesAt(date('Y') + 3);
        }
        
        $form    = $this->createForm(new MemberType(), $entity);
        if ($this->getRequest()->getMethod() == 'POST') {
                $form->bind($request);
                if ($form->isValid()) {
                    $entity->setJoinedAt(new \DateTime);
                    $entity->setPaid(false);
                    $entity->setMembershipType(Member::TYPE_CURRENT);
                    $em = $this->getDoctrine()->getEntityManager();
                    $em->persist($entity);
                    $em->flush();
                    return $this->forward('CumtsMainBundle:Membership:pay', array('auth_id' => $entity->getUsername()));
                }
        }
        return $this->render('CumtsMainBundle:Membership:join.html.twig', array(
                'entity' => $entity, 
                'form' => $form->createView(),
                'auth_id' => $auth_id,
        ));
    }
    
    public function logoutAction()
    {
        $token = $this->get('security.context')->getToken();
        if ($token) $token->getUser()->logOut();
	$this->get('request')->getSession()->invalidate();
        return $this->redirect('/');
    }

}
