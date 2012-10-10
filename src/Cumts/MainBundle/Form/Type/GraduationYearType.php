<?php
namespace Cumts\MainBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Cumts\MainBundle\Form\DataTransformer\GraduationYearTransformer;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GraduationYearType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new GraduationYearTransformer;
        $builder->addModelTransformer($transformer);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $years = array();
        $cur_year = date('Y');
        for ($i=0; $i<=7; $i++) {
                $years[$cur_year] = $cur_year;
                $cur_year++;
        }
    
        $resolver->setDefaults(array(
            'choices' => $years,
        ));
    }

    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'graduation_year';
    }
}
