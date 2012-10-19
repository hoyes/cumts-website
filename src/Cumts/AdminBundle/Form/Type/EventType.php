<?php
namespace Cumts\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('event_type');
        $builder->add('name');
        $builder->add('summary');
        $builder->add('body');
        $builder->add('start_at', 'datetime');
        $builder->add('end_at', 'datetime');
    }
    
    public function getName()
    {
        return 'event';
    }
}
