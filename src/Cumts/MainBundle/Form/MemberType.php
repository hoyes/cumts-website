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
            ->add('auth_id', 'text', array('label' => 'CRSid'))
            ->add('email', 'text', array('label' => 'Preferred e-mail'))
            ->add('membership_type', 'choice', array('choices' => array(
                0 => 'active',
                3 => 'special',
                2 => 'associate',
                4 => 'committee'
            )))
            ->add('joined_at', 'date')
            ->add('leaves_at', 'date')
            ->add('paid')
        ;
    }

    public function getName()
    {
        return 'cumts_mainbundle_membertype';
    }
}
