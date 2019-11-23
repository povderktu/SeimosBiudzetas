<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191013094952 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE expanse_type (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE expanse ADD type_id INT DEFAULT NULL, CHANGE member_id member_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE expanse ADD CONSTRAINT FK_A2581AF1C54C8C93 FOREIGN KEY (type_id) REFERENCES expanse_type (id)');
        $this->addSql('CREATE INDEX IDX_A2581AF1C54C8C93 ON expanse (type_id)');
        $this->addSql('ALTER TABLE member CHANGE reason reason VARCHAR(255) DEFAULT NULL, CHANGE dabartinis_limitas dabartinis_limitas DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE expanse DROP FOREIGN KEY FK_A2581AF1C54C8C93');
        $this->addSql('DROP TABLE expanse_type');
        $this->addSql('DROP INDEX IDX_A2581AF1C54C8C93 ON expanse');
        $this->addSql('ALTER TABLE expanse DROP type_id, CHANGE member_id member_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `member` CHANGE reason reason VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE dabartinis_limitas dabartinis_limitas DOUBLE PRECISION DEFAULT \'NULL\'');
    }
}
