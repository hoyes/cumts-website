<?php

namespace Cumts\MainBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

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
    
    public function findArchiveQuery()
    {
        $query = $this->createQueryBuilder("e")
            ->orderBy("e.start_at", "DESC")
            ->wherE("e.end_at < :now")
            ->setParameter('now', new \DateTime())
            ->getQuery();
        return $query;
    }

    public function findAllNonShows($page, $limit)
    {
        $query = $this->createQueryBuilder("e")
            ->where('e NOT INSTANCE OF (CumtsMainBundle:Show)')
            ->orderBy("e.start_at", "DESC")
            ->setMaxResults($limit)
            ->setFirstResult(($page-1)*$limit)
            ->getQuery();
        return $query->getResult();
    }

    public function findUpcoming()
    {
        $query = $this->createQueryBuilder("e")
            ->where('e.end_at > CURRENT_DATE()')
            ->orderBy("e.start_at", "ASC")
            ->getQuery();
        return $query->getResult();
    }
    
    public function getUpcoming($number, $except_id = -1)
    {
        return $this->createQueryBuilder('e')
            ->where('e.end_at > :now')
            ->andWhere('e.id != :except_id')
            ->orderBy('e.start_at', 'ASC')
            ->setMaxResults($number)
            ->setParameter('now', new \DateTime)
            ->setParameter('except_id', $except_id)
            ->getQuery()->getResult();
    }
}
