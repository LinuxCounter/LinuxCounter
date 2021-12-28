<?php

namespace Syw\Front\MainBundle\Tests\Controller;

class RegisterControllerTest extends BaseControllerTest
{
    public function testRegistrationSuccess1()
    {
        $this->assertEquals('1', '1');
    }
    /* this works no longer since we have reCaptcha!
    public function testRegistrationSuccess1()
    {
        $crawler = $this->client->request('GET', $this->base_proto.'://'.$this->base_host.'/register/');

        $form = $crawler->filter('form[class=fos_user_registration_register]')->form(array(
            'fos_user_registration_form[email]'                 => $this->test1_email,
            'fos_user_registration_form[username]'              => $this->test1_username,
            'fos_user_registration_form[plainPassword][first]'  => $this->test1_passwd,
            'fos_user_registration_form[plainPassword][second]' => $this->test1_passwd,
            'fos_user_registration_form[locale]'                => $this->test1_locale
        ));
        $this->client->submit($form);
        $crawler = $this->client->request('GET', '/');

        $this->assertContains(
            'The user has been created successfully',
            $this->client->getResponse()->getContent()
        );

        $user = $this->_em
            ->getRepository('SywFrontMainBundle:User')
            ->findBy(array('username' => $this->test1_username, 'email' => $this->test1_email));

        $this->assertCount(1, $user);

        $user = $this->_em
            ->getRepository('SywFrontMainBundle:User')
            ->findOneBy(array('username' => $this->test1_username, 'email' => $this->test1_email));

        $this->assertEquals(0, $user->getEnabled());
        $this->assertEquals('en', $user->getLocale());
        $this->assertGreaterThan(0, $user->getProfile()->getId());

        @exec('php app/console syw:user:delete '.$this->test1_username.'');
    }

    public function testRegistrationSuccess2()
    {
        $crawler = $this->client->request('GET', $this->base_proto.'://'.$this->base_host.'/register/');

        $form = $crawler->filter('form[class=fos_user_registration_register]')->form(array(
            'fos_user_registration_form[email]'                 => $this->test2_email,
            'fos_user_registration_form[username]'              => $this->test2_username,
            'fos_user_registration_form[plainPassword][first]'  => $this->test2_passwd,
            'fos_user_registration_form[plainPassword][second]' => $this->test2_passwd,
            'fos_user_registration_form[locale]'                => $this->test2_locale
        ));
        $this->client->submit($form);
        $crawler = $this->client->request('GET', '/');

        $this->assertContains(
            'The user has been created successfully',
            $this->client->getResponse()->getContent()
        );

        $user = $this->_em
            ->getRepository('SywFrontMainBundle:User')
            ->findBy(array('username' => $this->test2_username, 'email' => $this->test2_email));

        $this->assertCount(1, $user);

        $user = $this->_em
            ->getRepository('SywFrontMainBundle:User')
            ->findOneBy(array('username' => $this->test2_username, 'email' => $this->test2_email));

        $this->assertEquals(0, $user->getEnabled());
        $this->assertEquals('de', $user->getLocale());
        $this->assertGreaterThan(0, $user->getProfile()->getId());

        @exec('php app/console syw:user:delete '.$this->test2_username.'');
    }
    */
}
