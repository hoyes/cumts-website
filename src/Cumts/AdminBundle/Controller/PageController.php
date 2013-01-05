<?php

namespace Cumts\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class PageController extends Controller
{
    
    public function indexAction()
    {
        return $this->render('CumtsAdminBundle:Page:index.html.twig');
    }
}