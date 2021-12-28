<?php

namespace Syw\Front\MainBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class DistributionsRepository
 *
 * @author Christin Löhner <alex.loehner@linux.com>
 */
class DistributionsRepository extends EntityRepository
{
    public function findByNot($field, $value)
    {
        $qb = $this->createQueryBuilder('a');
        $qb->where($qb->expr()->not($qb->expr()->eq('a.'.$field, '?1')));
        $qb->setParameter(1, $value);

        return $qb->getQuery()
            ->getResult();
    }

    public function findByGreater($field, $value)
    {
        $qb = $this->createQueryBuilder('a');
        $qb->where($qb->expr()->gt('a.'.$field, '?1'));
        $qb->setParameter(1, $value);

        return $qb->getQuery()
            ->getResult();
    }

    public function findByLower($field, $value)
    {
        $qb = $this->createQueryBuilder('a');
        $qb->where($qb->expr()->lt('a.'.$field, '?1'));
        $qb->setParameter(1, $value);

        return $qb->getQuery()
            ->getResult();
    }
}
