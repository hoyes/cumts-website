<?php

namespace Cumts\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class MemberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {   
        $builder
            ->add('auth_id', 'text', array('label' => 'CRSid', 'required' => false))
            ->add('first_name')
            ->add('last_name')
            ->add('email', 'text', array('label' => 'Preferred e-mail'))
            ->add('membership_type', 'membership_type')
            ->add('college', 'college')
            ->add('joined_at', 'date', array('label' => 'Joined on', 'format' => 'd MMM y'))
            ->add('leaves_at', 'graduation_year', array('label' => 'Year of Graduation'))
            ->add('paid')
        ;
    }

    public function getName()
    {
        return 'cumts_mainbundle_membertype';
    }
}
