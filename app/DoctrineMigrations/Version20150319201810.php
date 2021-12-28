<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150319201810 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `translation` CHANGE COLUMN `trans_locale` `trans_locale` VARCHAR(5) NOT NULL DEFAULT \'de\' COLLATE \'utf8_unicode_ci\' AFTER `trans_key`');
        $this->addSql('ALTER TABLE `translation` CHANGE COLUMN `message_domain` `message_domain` VARCHAR(255) NOT NULL DEFAULT \'messages\' COLLATE \'utf8_unicode_ci\' AFTER `trans_locale`');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}
