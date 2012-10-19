<?php
namespace Cumts\AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class NamesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('camdram:names')
            ->setDescription('Sync show role data with members database')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $rolerepo = $em->getRepository('CumtsMainBundle:ShowRole');
        $memberrepo = $em->getRepository('CumtsMainBundle:Member');
        
        $roles = $rolerepo->getUnknownCamdramIds();
        foreach ($roles as $r) {
            $role = $rolerepo->findOneBy(array('camdram_id' => $r['camdram_id']));
            
            if (preg_match('/^(.*) ([a-z\-\\\']+)$/i',$role->getName(),$matches)) {
                $first_name = $matches[1];
                $last_name = $matches[2];
                $m = $memberrepo->findOneBy(array('last_name' => $last_name));
                if ($m) {
                    similar_text($first_name, $m->getFirstName(), $percent);
                    if ($percent > 50) {
                            $m->setCamdramId($role->getCamdramId());
                            $rolerepo->addMemberForCamdramId($m, $role->getCamdramId());
                            echo $role->getCamdramId().": ".$m->getFullName()."\r\n";
                    }
                }
            }
        }
        $em->flush();
        $output->writeln("done");
    }
}
