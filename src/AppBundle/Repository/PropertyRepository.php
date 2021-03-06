<?php

namespace AppBundle\Repository;

use AppBundle\Extra\PropertySearch;
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
     * @param string $type
     * @param int $page
     * @param bool $loadOnlyPublished
     * @return Paginator
     */
    public function loadProperties($max, string $type = null, int $page = 1, $loadOnlyPublished = true){

        $qb = $this->createQueryBuilder('p')
            ->setFirstResult(($page - 1) * $max)
            ->orderBy('p.id', 'DESC')
            ->setMaxResults($max)
        ;

        if($loadOnlyPublished){
            $qb->where('p.published = :published')
                ->setParameter('published', true);
        }

        if('location' === $type || 'vente' === $type){
            if('location' === $type){
                $qb->join('p.rental', 'type');
            }

            if('vente' === $type){
                $qb->join('p.sale', 'type');
            }
            $qb->addSelect('type');
        }



        return new Paginator($qb);

    }

    public function search(PropertySearch $search){
        $qb = $this->createQueryBuilder('p')
            ->where('p.published = :published')
            ->setParameter('published', true);

        if(null !== $search->getLocation()){
            $qb->andWhere('p.location = :location')
                ->setParameter('location', $search->getLocation());
        }

        $subLocation = trim(strip_tags($search->getSubLocation())) ;
        if(false === empty($subLocation)){
            $qb->andWhere('p.subLocation LIKE :subLocation')
                ->setParameter('subLocation', '%'.$subLocation.'%');
        }

        $minArea = (int) $search->getMinArea();
        if($minArea){
            $qb->andWhere('p.livingSpace >= :minArea')
                ->setParameter(':minArea', $minArea);
        }

        $maxArea = (int) $search->getMaxArea();
        if($maxArea){
            $qb->andWhere('p.livingSpace <= :maxArea')
                ->setParameter(':maxArea', $maxArea);
        }

        $bathRooms = (int) $search->getBathRooms();
        if($bathRooms){
            $qb->andWhere('p.bathroom = :bathrooms')
                ->setParameter(':bathrooms', $bathRooms);
        }

        $bedRooms = (int) $search->getBedRooms();
        if($bedRooms){
            $qb->andWhere('p.bedroom = :bedrooms')
                ->setParameter(':bedrooms', $bedRooms);
        }

        $minPrice = (int) $search->getPriceMin();
        $maxPrice = (int) $search->getPriceMax();
        if($minPrice || $maxPrice){
            $qb->leftJoin('p.sale', 's')
                ->leftJoin('p.rental', 'r')
                ->addSelect('s')
                ->addSelect('r');
        }
        if($minPrice){
            $qb->andWhere(
                $qb->expr()->orX(
                    $qb->expr()->gte('s.price', ':minPrice'),
                    $qb->expr()->gte('r.monthly', ':minPrice')
                )
            )
            ->setParameter('minPrice', $minPrice);
        }

        if($maxPrice){
            $qb->andWhere(
                $qb->expr()->orX(
                    $qb->expr()->lte('s.price', ':maxPrice'),
                    $qb->expr()->lte('r.monthly', ':maxPrice')
                )
            )
                ->setParameter('maxPrice', $maxPrice);
        }

        return $qb->getQuery()->getResult();

    }
}
