<?php

namespace Cumts\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code')
            ->add('title')
            ->add('body', 'textarea', array('attr' => array('class' => 'tinymce')))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cumts\MainBundle\Entity\Content'
        ));
    }

    public function getName()
    {
        return 'cumts_mainbundle_contenttype';
    }
}
