<?php
namespace Cumts\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class NewsType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('headline');
        $builder->add('summary');
        $builder->add('body');
        $builder->add('published_at', 'date');
    }
    
    public function getName()
    {
        return 'news';
    }
}
