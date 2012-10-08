<?php

namespace Cumts\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class MemberType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('first_name')
            ->add('last_name')
            ->add('email')
            ->add('membership_type')
            ->add('auth_id')
            ->add('created_at')
            ->add('updated_at')
            ->add('joined_at')
            ->add('leaves_at')
        ;
    }

    public function getName()
    {
        return 'cumts_mainbundle_membertype';
    }
}
