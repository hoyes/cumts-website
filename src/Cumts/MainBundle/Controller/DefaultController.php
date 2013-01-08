<?php

namespace Cumts\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sonata\BlockBundle\Block\BlockLoaderInterface;

class DefaultController extends Controller
{
    
    public function indexAction()
    {
        $repo = $this->getDoctrine()->getRepository('CumtsMainBundle:Event');
        $events = $repo->getUpcoming(3);
        
        $repo = $this->getDoctrine()->getRepository('CumtsMainBundle:News');
        $news = $repo->findRecent(2);
    
        return $this->render('CumtsMainBundle:Default:index.html.twig', array(
            'events' => $events,
            'news' => $news,
        ));
    }
    
    public function holdingAction()
    {
       return $this->render('CumtsMainBundle:Default:holding.html.twig', array());
    }

    public function pageAction($content_name)
    {
        $repo = $this->getDoctrine()->getRepository('CumtsMainBundle:Content');
        $content = $repo->findOneByCode($content_name);
        return $this->render('CumtsMainBundle:Default:page.html.twig', array('content' => $content));
    }

    public function blockAction($content_name)
    {
        $repo = $this->getDoctrine()->getRepository('CumtsMainBundle:Content');
        $content = $repo->findOneByCode($content_name);

        return $this->render('CumtsMainBundle:Default:block.html.twig', array('content' => $content));
    }
    
    public function headerImagesAction()
    {
        $repo = $this->getDoctrine()->getRepository('CumtsMainBundle:Photo');
        $photos = $repo->findRandom(4);
       // var_dump($photos);die();
        return $this->render('CumtsMainBundle:Default:header-photos.html.twig', array('photos' => $photos));
    }
}
