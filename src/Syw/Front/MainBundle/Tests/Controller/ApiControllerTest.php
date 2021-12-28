<?php

namespace Syw\Front\MainBundle\Tests\Controller;

class ApiControllerTest extends BaseControllerTest
{
    /*
     * @desc Check for using the base.html.twig
     */
    public function testApiIndexContent()
    {
        $crawler = $this->client->request('GET', '/api');
        $this->assertGreaterThan(0, $crawler->filter('html:contains("API")')->count());
    }
}
