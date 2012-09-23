<?php

namespace Cumts\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class NewsType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('headline')
            ->add('slug')
            ->add('summary')
            ->add('body')
            ->add('created_at')
            ->add('updated_at')
            ->add('published_at')
            ->add('created_by_id')
        ;
    }

    public function getName()
    {
        return 'cumts_mainbundle_newstype';
    }
}
