<?php

namespace Cumts\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ShowType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('camdram_id')
            ->add('title')
            ->add('author')
            ->add('venue')
            ->add('start_at')
            ->add('end_at')
            ->add('description', null, array('required' => false))
            ->add('ticket_url', null, array('required' => false))
            ->add('image', null, array('required' => false))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cumts\MainBundle\Entity\Show'
        ));
    }

    public function getName()
    {
        return 'cumts_mainbundle_showtype';
    }
}
