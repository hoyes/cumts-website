<?php

namespace Cumts\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class JoinType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $years = array();
        $cur_year = date('Y');
        for ($i=0; $i<=7; $i++) {
                $years[$cur_year."-06-30 00:00:00"] = $cur_year;
                $cur_year++;
        }
    
        $builder
            ->add('first_name')
            ->add('last_name')
            ->add('email', 'text', array('label' => 'Preferred e-mail address'))
            ->add('college', 'choice', array('choices' => array(
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
                "Gonville & Caius",
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
            )))
            ->add('leaves_at', 'choice', array('label' => 'Expected year of graduation', 'choices' => $years))
            ->add('auth_id', 'hidden')
        ;
    }

    public function getName()
    {
        return 'cumts_mainbundle_jointype';
    }
}
