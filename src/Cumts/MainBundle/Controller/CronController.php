<?php

namespace Cumts\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Camdram controller.
 *
 */
class CamdramController extends Controller
{

    public function updateAction()
    {


        $response = new Response();
        $response->setStatusCode(200);
        
        return $response;
    }


}
