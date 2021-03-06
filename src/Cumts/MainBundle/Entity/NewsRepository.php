<?php

namespace Cumts\MainBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * NewsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class NewsRepository extends EntityRepository
{
    public function findAllPaginated($page, $limit)
    {
        $query = $this->createQueryBuilder("n")
            ->orderBy("n.published_at", "DESC")
            ->setMaxResults($limit)
            ->setFirstResult(($page-1)*$limit)
            ->getQuery();
        return $query->getResult();
    }
    
    public function findRecent($number)
    {
        $query = $this->createQueryBuilder("n")
            ->orderBy("n.published_at", "DESC")
            ->setMaxResults($number)
            ->getQuery();
        return $query->getResult();
    }
}
