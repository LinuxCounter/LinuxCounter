<?php

namespace Syw\Front\ApiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends BaseControllerTest
{
    public function testIndex()
    {
        $basehost = $this->client->getKernel()->getContainer()->getParameter('api_host');
        $crawler = $this->client->request('GET', 'http://'.$basehost.'/');

        $this->assertTrue($crawler->filter('html:contains("Machine management")')->count() > 0);
    }
}
