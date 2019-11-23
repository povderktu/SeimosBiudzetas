<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190929185048 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE expanse CHANGE member_id member_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE member CHANGE reason reason VARCHAR(255) DEFAULT NULL, CHANGE dabartinis_limitas dabartinis_limitas DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE expanse CHANGE member_id member_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `member` CHANGE reason reason VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE dabartinis_limitas dabartinis_limitas DOUBLE PRECISION DEFAULT \'NULL\'');
    }
}
