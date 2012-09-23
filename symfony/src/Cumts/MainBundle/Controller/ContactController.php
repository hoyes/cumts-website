<?php

namespace Cumts\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ContactController extends Controller
{
    
    public function indexAction()
    {
        return $this->render('CumtsMainBundle:Contact:index.html.twig', array());
    }
}
