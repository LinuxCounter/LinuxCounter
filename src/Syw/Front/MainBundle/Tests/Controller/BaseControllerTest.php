<?php

namespace Syw\Front\MainBundle\Tests\Controller;

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

    protected $test1_username    = '4iz5t0w4tnzwn45ptwnhpw5t';
    protected $test1_email       = 'tester1@linuxcounter.net';
    protected $test1_passwd      = 'w4nzvw7t07v5hnvw508tzowf';
    protected $test1_locale      = 'en';

    protected $test2_username    = 'p4eo5u6zw40597tznwp3thqp';
    protected $test2_email       = 'tester2@linuxcounter.net';
    protected $test2_passwd      = '39486ztn043wt7nv40thowu4';
    protected $test2_locale      = 'de';

    protected $base_host         = 'dev.test.linuxcounter.net';
    protected $base_proto        = 'http';

    protected $api_host          = 'api.test.linuxcounter.net';
    protected $api_proto         = 'http';

    public function setUp()
    {
        @exec('php app/console syw:user:delete '.$this->test1_username.' >/dev/null 2>&1');
        @exec('php app/console syw:user:delete '.$this->test2_username.' >/dev/null 2>&1');
        $kernel = static::createKernel();
        $kernel->boot();
        $this->_em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
        $this->_em->beginTransaction();
        $this->client = static::createClient();
        $this->base_host = $this->client->getKernel()->getContainer()->getParameter('base_host');
        $this->base_proto = $this->client->getKernel()->getContainer()->getParameter('base_proto');
        $this->api_host = $this->client->getKernel()->getContainer()->getParameter('api_host');
        $this->api_proto = $this->client->getKernel()->getContainer()->getParameter('api_proto');

    }

    /**
     * Rollback changes.
     */
    public function tearDown()
    {
        $this->_em->rollback();
        @exec('php app/console syw:user:delete '.$this->test1_username.' >/dev/null 2>&1');
        @exec('php app/console syw:user:delete '.$this->test2_username.' >/dev/null 2>&1');
        parent::tearDown();
        $this->_em->close();
    }
}
