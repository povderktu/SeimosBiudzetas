<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191123144912 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE expanse CHANGE member_id member_id INT DEFAULT NULL, CHANGE tipas_id tipas_id INT DEFAULT NULL');
        $this->addSql('DROP INDEX UNIQ_70E4FA78F85E0677 ON member');
        $this->addSql('ALTER TABLE member DROP username, DROP password, CHANGE reason reason VARCHAR(255) DEFAULT NULL, CHANGE dabartinis_limitas dabartinis_limitas DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE expanse CHANGE member_id member_id INT DEFAULT NULL, CHANGE tipas_id tipas_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `member` ADD username VARCHAR(191) NOT NULL COLLATE utf8mb4_unicode_ci, ADD password VARCHAR(64) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE reason reason VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE dabartinis_limitas dabartinis_limitas DOUBLE PRECISION DEFAULT \'NULL\'');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_70E4FA78F85E0677 ON `member` (username)');
    }
}
