<?php

namespace Cumts\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\Criteria;

/**
 * Cumts\MainBundle\Entity\Show
 *
 * @ORM\Entity
 */
class Workshop extends Event
{
    protected $event_type = 'workshop';
    protected $event_string = 'Workshop';
}