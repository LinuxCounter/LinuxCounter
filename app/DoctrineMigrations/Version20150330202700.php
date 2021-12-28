<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150330202700 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `cities` ADD COLUMN `usernum` int(11) NULL DEFAULT \'0\'');
        $this->addSql('ALTER TABLE `architectures` ADD COLUMN `machinesnum` int(11) NULL DEFAULT \'0\'');
        $this->addSql('ALTER TABLE `classes` ADD COLUMN `machinesnum` int(11) NULL DEFAULT \'0\'');
        $this->addSql('ALTER TABLE `countries` ADD COLUMN `machinesnum` int(11) NULL DEFAULT \'0\'');
        $this->addSql('ALTER TABLE `cpus` ADD COLUMN `machinesnum` int(11) NULL DEFAULT \'0\'');
        $this->addSql('ALTER TABLE `distributions` ADD COLUMN `machinesnum` int(11) NULL DEFAULT \'0\'');
        $this->addSql('ALTER TABLE `kernels` ADD COLUMN `machinesnum` int(11) NULL DEFAULT \'0\'');
        $this->addSql('ALTER TABLE `purposes` ADD COLUMN `machinesnum` int(11) NULL DEFAULT \'0\'');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `cities` DROP `usernum`');
        $this->addSql('ALTER TABLE `architectures` DROP `machinesnum`');
        $this->addSql('ALTER TABLE `classes` DROP `machinesnum`');
        $this->addSql('ALTER TABLE `countries` DROP `machinesnum`');
        $this->addSql('ALTER TABLE `cpus` DROP `machinesnum`');
        $this->addSql('ALTER TABLE `distributions` DROP `machinesnum`');
        $this->addSql('ALTER TABLE `kernels` DROP `machinesnum`');
        $this->addSql('ALTER TABLE `purposes` DROP `machinesnum`');
    }
}
