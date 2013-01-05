<?php

namespace Cumts\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sonata\BlockBundle\Block\BlockLoaderInterface;

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

    public function pageAction($block_name)
    {
        /** @var $manager BlockLoaderInterface */
        $manager = $this->get('sonata.block.loader.chain');
        $block = $manager->load(array('name' => '/blocks/'.$block_name));

        return $this->render('CumtsMainBundle:Default:page.html.twig', array('block' => $block));
    }

    public function blockAction($block_name)
    {
        $manager = $this->get('sonata.block.loader.chain');
        $block = $manager->load(array('name' => '/blocks/'.$block_name));

        return $this->render('CumtsMainBundle:Default:block.html.twig', array('block' => $block));
    }
}
