<?php
namespace Cumts\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class NewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('headline');
        $builder->add('summary');
        $builder->add('body', 'textarea', array('attr' => array('class' => 'tinymce')));
        $builder->add('published_at', 'date');
    }
    
    public function getName()
    {
        return 'news';
    }
}
