<?php
namespace Cumts\MainBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Cumts\MainBundle\Entity\Member;

class MembershipTypeType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {   
        $resolver->setDefaults(array('choices' => array(
            Member::TYPE_CURRENT => 'active',
            Member::TYPE_SPECIAL => 'special',
            Member::TYPE_ASSOCIATE => 'associate',
            Member::TYPE_COMMITTEE => 'committee'
        )));
    }

    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'membership_type';
    }
}
