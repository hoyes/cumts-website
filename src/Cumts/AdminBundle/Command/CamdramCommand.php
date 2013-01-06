<?php
namespace Cumts\AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CamdramCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('camdram:sync')
            ->setDescription('Sync list of shows and show data with camdram')
            ->addArgument(
                'shows',
                InputArgument::OPTIONAL,
                'If set will only sync the list of shows'
            )
            ->addArgument(
               'data',
               InputArgument::OPTIONAL,
               'If set, will only sync the show data'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $ids = $this->getContainer()->get('camdram')->getShows();
        $shows = $this->getContainer()->get('doctrine.orm.entity_manager')->getRepository('CumtsMainBundle:Show')->findAll();
        foreach ($shows as $show) {
            $ids[] = $show->getCamdramId();
        }
        
        foreach ($ids as $id) {
            $output->writeln("Checking show ".$id);
            $this->getContainer()->get('camdram')->addOrUpdateShow($id);
        }
    }
}
