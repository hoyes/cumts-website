<?php
namespace Cumts\AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Doctrine\ODM\PHPCR\Document\Generic;
use Doctrine\ODM\PHPCR\DocumentManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Cmf\Bundle\BlockBundle\Document\SimpleBlock;

class CreateDocumentsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('cumts:documents:create')
            ->setDescription('Create default documents for public site')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var $manager DocumentManager */
        $manager = $this->getContainer()->get('doctrine_phpcr.odm.default_document_manager');
        // Get the root document from the PHPCR
        $rootDocument = $manager->find(null, '/');

        $document = $manager->find(null, 'blocks');
        if (!$document) {
            // Create a generic PHPCR document under the root, to use as a kind of category for the blocks
            $document = new Generic();
            $document->setParent($rootDocument);
            $document->setNodename('blocks');
            $manager->persist($document);
        }

        $this->create('home', 'Home', $document, $output);
        $this->create('get_involved', 'Get Involved', $document, $output);
        $this->create('about_us', 'About Us', $document, $output);
        $this->create('contact_us', 'Contact Us', $document, $output);
        $this->create('membership', 'Membership', $document, $output);
    }

    protected function create($name, $title, $parent, OutputInterface $output)
    {
        /** @var $manager DocumentManager */
        $manager = $this->getContainer()->get('doctrine_phpcr.odm.default_document_manager');

        $doc = $manager->find(null, 'blocks/'.$name);
        if (!$doc) {
            // Create a new SimpleBlock (see http://symfony.com/doc/master/cmf/bundles/block.html#block-types)
            $myBlock = new SimpleBlock();
            $myBlock->setParentDocument($parent);
            $myBlock->setName($name);
            $myBlock->setTitle($title);
            $myBlock->setContent('Put some content here');
            $manager->persist($myBlock);

            // Commit $document and $block to the database
            $manager->flush();

            $output->writeln('Created doc '.$name);
        }
    }
}
