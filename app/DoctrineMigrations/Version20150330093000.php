<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150330093000 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user_profile` ADD COLUMN `created_at` DATETIME NOT NULL AFTER `sincewhen');
        $this->addSql('ALTER TABLE `user_profile` ADD COLUMN `modified_at` DATETIME NULL AFTER `created_at');
        $this->addSql('ALTER TABLE `fos_user` ADD COLUMN `mailpref_id` int(11) NULL AFTER `profile_id');

        $this->addSql('CREATE TABLE `mail` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`user` INT(11) NULL DEFAULT NULL,
	`newsletter_allowed` TINYINT(1) NULL DEFAULT \'1\',
	`admin_allowed` TINYINT(1) NULL DEFAULT \'1\',
	`other_users_allowed` TINYINT(1) NULL DEFAULT \'1\',
	`modified_at` DATETIME NULL DEFAULT NULL,
	PRIMARY KEY (`id`),
	INDEX `user` (`user`),
	CONSTRAINT `FK_mail_fos_user` FOREIGN KEY (`user`) REFERENCES `fos_user` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
)
COLLATE=\'utf8_general_ci\'
ENGINE=InnoDB');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user_profile` DROP `created_at`');
        $this->addSql('ALTER TABLE `user_profile` DROP `modified_at`');
        $this->addSql('ALTER TABLE `fos_user` DROP `mailpref_id`');
        $this->addSql('DROP TABLE `mail`');
    }
}
