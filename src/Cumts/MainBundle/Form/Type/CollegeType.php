<?php
namespace Cumts\MainBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CollegeType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    { 
        $resolver->setDefaults(array(
            'choices' => array(
                "Christ's" => "Christ's", 
                "Churchill" => "Churchill", 
                "Clare" => "Clare",
                "Clare Hall" => "Clare Hall",
                "Corpus Christi" => "Corpus Christi",
                "Darwin" => "Darwin",
                "Downing" => "Downing",
                "Emmanuel" => "Emmanuel",
                "Fitzwilliam" => "Fitzwilliam",
                "Girton" => "Girton",
                "Gonville & Caius" => "Gonville & Caius",
                "Homerton" => "Homerton",
                "Hughes Hall" => "Hughes Hall",
                "Jesus" => "Jesus", 
                "King's" => "King's",
                "Lucy Cavendish" => "Lucy Cavendish",
                "Magdalene" => "Magdalene",
                "Murray Edwards" => "Murray Edwards",
                "Newnham" => "Newnham",
                "Pembroke" => "Pembroke",
                "Peterhouse" => "Peterhouse",
                "Queens'" => "Queens'",
                "Robinson" => "Robinson",
                "Selwyn" => "Selwyn",
                "Sidney Sussex" => "Sidney Sussex",
                "St Catharine's" => "St Catharine's",
                "St Edmund's" => "St Edmund's",
                "St John's" => "St John's",
                "Trinity" => "Trinity",
                "Trinity Hall" => "Trinity Hall",
                "Wolfson" => "Wolfson",
            )
        ));
    }

    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'college';
    }
}
