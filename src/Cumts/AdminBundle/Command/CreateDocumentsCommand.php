<?php
namespace Cumts\AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Doctrine\ODM\PHPCR\Document\Generic;
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
        $manager = $this->getContainer()->get('doctrine_phpcr.odm.default_document_manager');

        // Get the root document from the PHPCR
        $rootDocument = $manager->find(null, '/');

        // Create a generic PHPCR document under the root, to use as a kind of category for the blocks
        $document = new Generic();
        $document->setParent($rootDocument);
        $document->setNodename('blocks');
        $manager->persist($document);

        // Create a new SimpleBlock (see http://symfony.com/doc/master/cmf/bundles/block.html#block-types)
        $myBlock = new SimpleBlock();
        $myBlock->setParentDocument($document);
        $myBlock->setName('getting_involved');
        $myBlock->setTitle('Getting Involved');
        $myBlock->setContent('Put some content here');
        $manager->persist($myBlock);

        // Commit $document and $block to the database
        $manager->flush();
    }
}
