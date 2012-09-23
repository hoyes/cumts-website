<?php

namespace Cumts\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class MembershipController extends Controller
{
    
    public function indexAction()
    {
        return $this->render('CumtsMainBundle:Membership:index.html.twig', array());
    }
}
