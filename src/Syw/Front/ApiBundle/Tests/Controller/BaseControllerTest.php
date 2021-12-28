<?php

namespace Syw\Front\ApiBundle\Tests\Controller;

use Syw\Front\MainBundle\Tests\BaseTestCase;

/**
 * Class BaseControllerTest
 *
 * @author Christin Löhner <alex.loehner@linux.com>
 */
abstract class BaseControllerTest extends BaseTestCase
{
    /**
     * @var EntityManager
     */
    public $_em;

    protected $client = null;

    public function setUp()
    {
        $kernel = static::createKernel();
        $kernel->boot();
        $this->_em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
        $this->_em->beginTransaction();
        $this->client = static::createClient();
    }

    /**
     * Rollback changes.
     */
    public function tearDown()
    {
        $this->_em->rollback();
        parent::tearDown();
        $this->_em->close();
    }
}
