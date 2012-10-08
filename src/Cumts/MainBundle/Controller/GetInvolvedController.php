<?php

namespace Cumts\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class GetInvolvedController extends Controller
{
    
    public function indexAction()
    {
        return $this->render('CumtsMainBundle:GetInvolved:index.html.twig', array());
    }
}
