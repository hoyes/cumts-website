<?php

namespace Cumts\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Cumts\MainBundle\Entity\Member;
use Cumts\MainBundle\Form\JoinType;

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
        $this->redirect($this->generateUrl("CumtsMainBundle_homepage"));
    }
    
    public function completeAction()
    {
	$auth_id = $this->get('security.context')->getToken()->getUser()->getUsername();
        $em = $this->getDoctrine()->getEntityManager();
        $member = $em->getRepository('CumtsMainBundle:Member')->findOneBy(array('auth_id' => $auth_id));
        return $this->render('CumtsMainBundle:Membership:complete.html.twig', array('auth_id' => $auth_id, 'member' => $member));
    }
    
    public function joinAction()
    {
	$auth_id = $this->get('security.context')->getToken()->getUser()->getUsername();
        $request = $this->getRequest();
        $entity  = new Member();
                
        if ($auth_id) {
                $details = $this->getDetails($auth_id);
                $entity->setFirstName($details['first_name']);
                $entity->setLastName($details['last_name']);
                $entity->setAuthId($auth_id);
                $entity->setCollege($details['college']);
                $entity->setEmail($details['email']);
                $entity->setJoinedAt(new \DateTime);
        
                $year = date("Y") + 3;
                $default_leave = $year."-06-30 00:00:00";
                $entity->setLeavesAt($default_leave);
        }
        
        $form    = $this->createForm(new JoinType(), $entity);
        if ($this->getRequest()->getMethod() == 'POST') {
                $form->bindRequest($request);
                if ($form->isValid()) {
                    $entity->setJoinedAt(new \DateTime);
                    $entity->setPaid(false);
                    $entity->setLeavesAt(new \DateTime($entity->getLeavesAt()));
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
    
    private function getDetails($id) {
        $l = \ldap_connect("ldap.lookup.cam.ac.uk");
        $dn = "ou=people,o=University of Cambridge,dc=cam,dc=ac,dc=uk";
        $r = \ldap_search($l, $dn, "(uid=".$id.")", array("misaffiliation", "sn", "ou", "displayname", "instid", "mail"));
        $info = \ldap_get_entries($l, $r);
        $is_student = array_search("student",$info[0]["misaffiliation"]) !== false;
        $last_name = $info[0]["sn"][0];
        $name = $info[0]["displayname"][0];
        $first_name = trim(str_replace($last_name, "", $name));
        $email = $info[0]["mail"][0];
        $college = NULL;
        if (substr_count($first_name, ".") > 0) $first_name = "";
        
        for ($i=0; $i < $info[0]["ou"]["count"]; $i++) {
                $ou = $info[0]["ou"][$i];
                if (preg_match("/^([A-Z'a-z ]+) \-/", $ou, $matches)) {
                        $college = $matches[1];
                        if (substr($college,-7) == "College") $college = substr($college,0,-8);
                }
        }
        
        return array(
                'name' => $name,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'is_student' => $is_student, 
                'college' => $college,
                'email' => $email,
                'auth_id' => $id,
        );
    }
    
    public function logoutAction()
    {
        $token = $this->get('security.context')->getToken();
        if ($token) $token->getUser()->logOut();
	$this->get('request')->getSession()->invalidate();
        return $this->redirect('/');
    }
}
