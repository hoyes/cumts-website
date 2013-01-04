<?php

namespace Cumts\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class EventType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('slug')
            ->add('start_at')
            ->add('end_at')
            ->add('summary')
            ->add('body')
        ;
    }

    public function getName()
    {
        return 'cumts_mainbundle_eventtype';
    }
}
