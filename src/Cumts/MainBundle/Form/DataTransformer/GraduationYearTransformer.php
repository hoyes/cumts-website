<?php
namespace Cumts\MainBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;


class GraduationYearTransformer implements DataTransformerInterface
{

    public function transform($value) {
        if ($value) return $value->format('Y');
        else return NULL;
    }
    
    public function reverseTransform($value) {
        return new \DateTime($value.'-09-30 00:00:00');
    }

}
