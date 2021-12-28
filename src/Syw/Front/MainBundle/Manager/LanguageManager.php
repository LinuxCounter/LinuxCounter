<?php

namespace Syw\Front\MainBundle\Manager;

use Syw\Front\MainBundle\Entity\Languages;

/**
 * Class LanguageManager
 *
 * @author Christin Löhner <alex.loehner@linux.com>
 */
class LanguageManager extends AbstractManager
{
    /**
     * create
     * Insert new entry to Languages table.
     *
     * @param Languages $obj
     * @return void
     */
    public function create(Languages $obj)
    {
        $this->getManager()->persist($obj);

        $this->getManager()->flush();
    }

    /**
     * update
     * Update entry to Languages table.
     *
     * @param Languages $obj
     * @return void
     */
    public function update(Languages $obj)
    {
        $this->getManager()->persist($obj);

        $this->getManager()->flush();
    }

    /**
     * delete
     * Delete entry to Languages table.
     *
     * @param Languages $obj
     * @return void
     */
    public function delete(Languages $obj)
    {
        $this->getManager()->remove($obj);

        $this->getManager()->flush();
    }

    /**
     * findAll
     * Find all records from Languages table.
     *
     * @return Languages[]
     */
    public function findAll(array $criteria = array(), array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * getAll
     * Get all records from Languages table.
     *
     * @return Languages[]
     */
    public function getAll()
    {
        return $this->findAll();
    }

    /**
     * findById
     * Find records from id
     *
     * @return Languages
     */
    public function findById($id)
    {
        return $this->getRepository()->find($id);
    }

    /**
     * findOneBy
     * Find one records by criteria from Languages table.
     *
     * @return Languages
     */
    public function findOneBy($criteria)
    {
        return $this->getRepository()->findOneBy($criteria);
    }

    /**
     * findBy
     * Find records from criteria
     *
     * @return Languages
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->getRepository()->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * getRepository
     * Get Languages entity repository object
     *
     * @return LanguagesRepository
     */
    public function getRepository()
    {
        return $this->getManager()->getRepository('SywFrontMainBundle:Languages');
    }
}
