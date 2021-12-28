<?php

namespace Syw\Front\MainBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class CitiesRepository
 *
 * @author Christin Löhner <alex.loehner@linux.com>
 */
class CitiesRepository extends EntityRepository
{
    public function findLikeName($q)
    {
        return $this->getManager()
            ->createQuery('SELECT c.id AS id, c.name AS value, LOWER(c.isoCountryCode) AS locale, c.latitude, c.longitude FROM SywFrontMainBundle:Cities c WHERE c.name LIKE \''.$q.'%\' ORDER BY c.name ASC')
            ->getResult();
    }

    public function find($id)
    {
        return $this->getManager()
            ->createQuery("SELECT c.id FROM SywFrontMainBundle:Cities c WHERE c.id = '".$id."'")
            ->getResult();
    }
}
