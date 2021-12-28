<?php

namespace Syw\Front\MainBundle\Tests\Controller;

class TranslationManagerTest extends BaseControllerTest
{
    public function testGetAllTranslations()
    {
        $trans = $this->_em->getRepository('AsmTranslationLoaderBundle:Translation')->findAll();
        // At least 2000 translations must be existent in the database
        $this->assertGreaterThan(1999, sizeof($trans));
    }

    public function testGetAllMessagesTranslations()
    {
        $trans = $this->_em->getRepository('AsmTranslationLoaderBundle:Translation')->findAll(array('messageDomain' => 'messages'));
        // At least 12 translations must be existent in the database
        $this->assertGreaterThan(11, sizeof($trans));
    }
}
