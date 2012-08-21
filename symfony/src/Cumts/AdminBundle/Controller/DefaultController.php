<?php

namespace Cumts\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction()
    {
        return $this->render('CumtsAdminBundle:Default:index.html.twig');
    }
}
