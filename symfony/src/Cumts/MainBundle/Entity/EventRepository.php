<?php

namespace Cumts\MainBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * EventRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EventRepository extends EntityRepository
{
    public function findAllPaginated($page, $limit)
    {
        $query = $this->createQueryBuilder("e")
            ->orderBy("e.start_at", "DESC")
            ->setMaxResults($limit)
            ->setFirstResult(($page-1)*$limit)
            ->getQuery();
        return $query->getResult();
    }
}