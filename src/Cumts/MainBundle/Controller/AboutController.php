<?php

namespace Cumts\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class AboutController extends Controller
{
    
    public function indexAction()
    {
        return $this->render('CumtsMainBundle:About:index.html.twig', array());
    }
}
