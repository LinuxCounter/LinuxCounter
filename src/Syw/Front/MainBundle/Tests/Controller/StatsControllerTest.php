<?php

namespace Syw\Front\MainBundle\Tests\Controller;

class StatsControllerTest extends BaseControllerTest
{
    /*
     * @desc Check for using the base.html.twig
     */
    public function testStatsIndexContent()
    {
        $crawler = $this->client->request('GET', $this->base_proto.'://'.$this->base_host.'/statistics');
        $this->assertGreaterThan(0, $crawler->filter('html:contains("Statistics")')->count());
    }

    /*
     * @desc Check for using the base.html.twig
     */
    public function testStatsGuessContent()
    {
        $crawler = $this->client->request('GET', $this->base_proto.'://'.$this->base_host.'/statistics/guess');
        $this->assertGreaterThan(0, $crawler->filter('html:contains("Guess")')->count());
    }
}
