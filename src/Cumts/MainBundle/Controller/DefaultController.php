<?php

namespace Cumts\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction()
    {
        return $this->render('CumtsMainBundle:Default:index.html.twig', array());
    }
    
    public function holdingAction()
    {
       return $this->render('CumtsMainBundle:Default:holding.html.twig', array());
    }
}
