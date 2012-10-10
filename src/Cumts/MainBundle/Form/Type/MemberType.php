<?php

namespace Cumts\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class MemberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
    
        $builder
            ->add('first_name')
            ->add('last_name')
            ->add('email', 'text', array('label' => 'Preferred e-mail address'))
            ->add('college', 'college')
            ->add('leaves_at', 'graduation_year', array('label' => 'Expected year of graduation'))
            //->add('auth_id', 'hidden')
        ;
    }

    public function getName()
    {
        return 'cumts_mainbundle_membertype';
    }
}
