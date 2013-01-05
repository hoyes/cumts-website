<?php

namespace Cumts\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('label' => 'Product name'))
            ->add('price', 'number', array('label' => 'Product price (GBP)'))
            ->add('members_price', 'number', array('label' => 'Member\'s only price (GBP) (optional)', 'required' => false))
            ->add('max_quantity', 'number', array('label' => 'Maximum quantity per person', 'required' => false))
            ->add('contact_email', 'email', array('label' => 'Contact email'))
            ->add('number_available', 'number', array('label' => 'Number of items available', 'required' => false))
            ->add('requires_membership')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cumts\MainBundle\Entity\Product'
        ));
    }

    public function getName()
    {
        return 'cumts_mainbundle_producttype';
    }
}