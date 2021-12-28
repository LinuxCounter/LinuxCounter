<?php

namespace Syw\Front\MainBundle\Tests\Controller;

class LanguageManagerTest extends BaseControllerTest
{
    public function testGetAllLanguages()
    {
        $languages = $this->_em->getRepository('SywFrontMainBundle:Languages')->findAll();
        // At least two languages (en and de) must be existent in the database
        $this->assertGreaterThan(1, sizeof($languages));
    }

    public function testGetGermanLanguage()
    {
        $language = $this->_em->getRepository('SywFrontMainBundle:Languages')->findOneBy(array('locale' => 'de'));
        $this->assertGreaterThan(0, sizeof($language));
    }

    public function testGetEnglishLanguage()
    {
        $language = $this->_em->getRepository('SywFrontMainBundle:Languages')->findOneBy(array('language' => 'English'));
        $this->assertGreaterThan(0, sizeof($language));
    }

    public function testGetGermanLanguageById()
    {
        $language = $this->_em->getRepository('SywFrontMainBundle:Languages')->findById(2);
        $this->assertGreaterThan(0, sizeof($language));
    }
}
