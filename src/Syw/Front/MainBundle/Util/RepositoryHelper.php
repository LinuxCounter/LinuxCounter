<?php

namespace Syw\Front\MainBundle\Util;

use Doctrine\ORM\EntityManager;

/**
 * Class RepositoryHelper
 *
 * @author Christin Löhner <alex.loehner@linux.com>
 */
class RepositoryHelper
{
    protected $manager;

    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
    }

    public function getRepositories()
    {
        $cities = $this->manager->getRepository('SywFrontMainBundle:Cities');
        $language = $this->manager->getRepository('SywFrontMainBundle:Language');
        $userProfile = $this->manager->getRepository('SywFrontMainBundle:UserProfile');

        return array('cities' => $cities, 'language' => $language, 'userProfile' => $userProfile);
    }
}
