<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150319153720 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs

        $this->addSql('CREATE TABLE `languages` ( `id` INT(11) NOT NULL AUTO_INCREMENT, `locale` VARCHAR(7) NOT NULL, `language` VARCHAR(128) NOT NULL, PRIMARY KEY (`id`), INDEX `locale` (`locale`) ) COLLATE=\'utf8_general_ci\' ENGINE=InnoDB');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

        $this->addSql('DROP TABLE `languages`');
    }
}
