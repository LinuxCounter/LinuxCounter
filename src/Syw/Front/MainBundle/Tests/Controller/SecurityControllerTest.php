<?php

namespace Syw\Front\MainBundle\Tests\Controller;

class SecurityControllerTest extends BaseControllerTest
{
    /* this works no longer since we can not register because of reCaptcha
    public function testLoginEnSuccess()
    {
        @exec('php app/console syw:user:create '.$this->test1_username.' '.$this->test1_email.' '.$this->test1_passwd.' en >/dev/null 2>&1 3>&1 4>&1');

        $crawler = $this->client->request('GET', $this->base_proto.'://'.$this->base_host.'/login');

        $form = $crawler->selectButton('Login')->form(array( '_username' => $this->test1_email, '_password' => $this->test1_passwd ));
        $this->client->submit($form);

        $crawler = $this->client->followRedirect();

        $this->assertCount(1, $crawler->filter('li a:contains("Logout")'));

        $link = $crawler->selectLink('Show Profile')->link();
        $crawler = $this->client->click($link);

        $this->assertCount(1, $crawler->filter('html:contains("'.$this->test1_email.'")'));

        @exec('php app/console syw:user:delete '.$this->test1_username.'');
    }

    public function testLoginDeSuccess()
    {
        @exec('php app/console syw:user:create '.$this->test2_username.' '.$this->test2_email.' '.$this->test2_passwd.' de >/dev/null 2>&1 3>&1 4>&1');

        $crawler = $this->client->request('GET', $this->base_proto.'://'.$this->base_host.'/login');

        $form = $crawler->selectButton('Login')->form(array( '_username' => $this->test2_email, '_password' => $this->test2_passwd ));
        $this->client->submit($form);

        $crawler = $this->client->followRedirect();
        $this->assertCount(1, $crawler->filter('li a:contains("Ausloggen")'));

        $link = $crawler->selectLink('Mein Profil')->link();
        $crawler = $this->client->click($link);

        $this->assertCount(1, $crawler->filter('html:contains("'.$this->test2_email.'")'));

        @exec('php app/console syw:user:delete '.$this->test2_username.'');
    }
    */

    public function testLoginFailure()
    {
        $crawler = $this->client->request('GET', $this->base_proto.'://'.$this->base_host.'/login');

        $form = $crawler->selectButton('Login')->form(array( '_username' => $this->test1_email, '_password' => $this->test1_passwd.'xyz' ));
        $this->client->submit($form);

        $crawler = $this->client->followRedirect();

        $this->assertCount(1, $crawler->filter('html:contains("Invalid credentials.")'));
    }
}
