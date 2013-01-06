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
            ->add('title')
            ->add('author')
            ->add('venue')
            ->add('ticket_url')
            ->add('camdram_id')
            ->add('start_at')
            ->add('end_at')
            ->add('image', 'image_upload')
            ->add('summary', 'textarea', array('attr' => array('class' => 'tinymce')))
            ->add('body', 'textarea', array('attr' => array('class' => 'tinymce')))
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
