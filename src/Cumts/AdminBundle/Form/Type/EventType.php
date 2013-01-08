<?php
namespace Cumts\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title')
            ->add('venue')
            ->add('ticket_url')
            ->add('summary')
            ->add('image', 'image_upload')
            ->add('body', 'textarea', array('attr' => array('class' => 'tinymce')))
            ->add('start_at', 'datetime')
            ->add('end_at', 'datetime')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cumts\MainBundle\Entity\Event'
        ));
    }
    
    public function getName()
    {
        return 'event';
    }
}
