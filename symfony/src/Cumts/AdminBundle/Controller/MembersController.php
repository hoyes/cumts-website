<?php

namespace Cumts\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Cumts\MainBundle\Entity\Member;

class MembersController extends Controller
{
    
    public function indexAction()
    {
        $repo = $this->getDoctrine()->getRepository("CumtsMainBundle:Member");
        $ms = $repo->findAll();
        foreach ($ms as $m) {
            if (preg_match("/\@cam\.ac\.uk$/i", $m->getEmail())) {
                $m->setAuthId($m->getEmail());
            }
        }
        $this->getDoctrine()->getEntityManager()->flush();
    }
}
