<?php

namespace AppBundle\Repository;

use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * PropertyRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PropertyRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param $max
     * @param int $page
     * @return Paginator
     */
    public function loadProperties($max, int $page = 1){
        $qb = $this->createQueryBuilder('p')
            ->setFirstResult(($page - 1) * $max)
            ->orderBy('p.id', 'DESC')
            ->setMaxResults($max);

        return new Paginator($qb);

    }
}
